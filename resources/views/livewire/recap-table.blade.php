<div class="flex flex-col w-full h-full" wire:id="recap-table">
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Recap Table</h1>
    </div>

    <div class="flex-grow overflow-x-auto"
        x-data="{
            columns: @js($columns),
            draggingCard: null,
            sourceColumn: null,
            showModal: false,
            selectedCard: null,

            startDrag(column, card) {
                this.draggingCard = card;
                this.sourceColumn = column;
            },

            endDrag(targetColumn) {
                if (!this.draggingCard) return;

                // Remove from source column
                const sourceIndex = this.columns.findIndex(col => col.id === this.sourceColumn.id);
                const cardIndex = this.columns[sourceIndex].cards.findIndex(c => c.id === this.draggingCard.id);

                if (cardIndex > -1) {
                    const [card] = this.columns[sourceIndex].cards.splice(cardIndex, 1);

                    // Actualizar el estado de la tarjeta según la columna de destino
                    if (targetColumn.id === 1) {
                        card.status = 'TO';
                    } else if (targetColumn.id === 2) {
                        card.status = 'PROCESS';
                    } else if (targetColumn.id === 3) {
                        card.status = 'DO';
                    }

                    // Add to target column
                    const targetIndex = this.columns.findIndex(col => col.id === targetColumn.id);
                    this.columns[targetIndex].cards.push(card);

                    // Notify Livewire about the change
                    $wire.moveCard(this.sourceColumn.id, targetColumn.id, this.draggingCard.id);
                }

                this.draggingCard = null;
                this.sourceColumn = null;
            },

            updateCardStatus(cardId, newStatus) {
                // Buscar la tarjeta en todas las columnas y actualizar su estado
                this.columns.forEach(column => {
                    const cardIndex = column.cards.findIndex(card => card.id === cardId);
                    if (cardIndex > -1) {
                        column.cards[cardIndex].status = newStatus;
                    }
                });
            },

            dragOver(e) {
                e.preventDefault();
            },

            openCardModal(card) {
                this.selectedCard = card;
                this.showModal = true;
            }
        }"
        @card-moved.window="updateCardStatus($event.detail.cardId, $event.detail.newStatus)"
    >
        <div class="flex gap-4 h-full pb-4 min-h-[400px]">
            <template x-for="column in columns" :key="column.id">
                <div
                    class="flex flex-col min-w-[300px] w-full md:w-1/3 bg-gray-100 dark:bg-gray-700 rounded-lg p-4"
                    @dragover.prevent
                    @drop="endDrag(column)"
                >
                    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white" x-text="column.title"></h3>

                    <div class="flex flex-col gap-3 flex-grow">
                        <template x-for="card in column.cards" :key="card.id">
                            <div
                                class="bg-white dark:bg-gray-800 p-3 rounded shadow transition-all duration-300 cursor-pointer hover:shadow-md border border-gray-200 dark:border-gray-600"
                                :class="draggingCard && draggingCard.id === card.id ? 'opacity-50 scale-105' : ''"
                                draggable="true"
                                @dragstart="startDrag(column, card)"
                                @click="openCardModal(card)"
                            >
                                <div class="font-medium mb-2 text-gray-800 dark:text-white" x-text="card.title"></div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mb-2 line-clamp-2" x-text="card.content"></div>
                                <div class="flex justify-between mt-2">
                                    <span class="text-xs px-2 py-1 rounded-full font-medium text-gray-500 dark:text-gray-400" x-text="card.date"></span>
                                    <span
                                        class="text-xs px-2 py-1 rounded-full font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100"
                                        x-text="card.status"
                                    ></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Modal -->
        <div
            x-show="showModal"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm bg-white/30 dark:bg-gray-900/30"
            @click.self="showModal = false"
        >
            <div class="flex items-center justify-center min-h-screen p-4">
                <div
                    class="bg-white/95 dark:bg-gray-800/95 rounded-lg w-[800px] h-[600px] shadow-xl border border-gray-200 dark:border-gray-700 flex flex-col backdrop-blur-md"
                    @click.stop
                >
                    <div class="flex justify-between items-start p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white" x-text="selectedCard?.title"></h3>
                        <button
                            @click="showModal = false"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 p-6 overflow-y-auto">
                        <p class="text-gray-600 dark:text-gray-300 text-lg" x-text="selectedCard?.content"></p>
                    </div>
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400" x-text="selectedCard?.date"></span>
                            <span
                                class="px-4 py-2 text-sm rounded-full font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100"
                                x-text="selectedCard?.status"
                            ></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between mt-auto text-gray-700 dark:text-gray-300">
        <div>
            <p>{{ $currentDate }}</p>
        </div>
        <div>
            <p>A machin, apoco si</p>
        </div>
    </div>
</div>
