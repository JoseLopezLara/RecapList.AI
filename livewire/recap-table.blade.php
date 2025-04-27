<div class="flex flex-col w-full h-full">
    <div class="mb-4">
        <h1 class="text-2xl font-bold">Recap Table</h1>
    </div>

    <div class="flex-grow overflow-x-auto"
         x-data="{
            draggingCard: null,
            sourceColumn: null,

            startDrag(column, card) {
                this.draggingCard = card;
                this.sourceColumn = column;
            },

            endDrag(targetColumn) {
                if (!this.draggingCard) return;

                // Call Livewire method to handle the card movement
                $wire.moveCard(this.sourceColumn.id, targetColumn.id, this.draggingCard.id);

                this.draggingCard = null;
                this.sourceColumn = null;
            },

            dragOver(e) {
                e.preventDefault();
            }
         }">
        <div class="flex gap-4 h-full pb-4 min-h-[400px]">
            <template x-for="column in $wire.columns" :key="column.id">
                <div
                    class="flex flex-col min-w-[300px] w-full md:w-1/3 bg-gray-100 rounded-lg p-4"
                    @dragover.prevent
                    @drop="endDrag(column)"
                >
                    <h3 class="text-lg font-semibold mb-3" x-text="column.title"></h3>

                    <div class="flex flex-col gap-3 flex-grow">
                        <template x-for="card in column.cards" :key="card.id">
                            <div
                                class="bg-white p-3 rounded shadow transition-all duration-300 cursor-move hover:shadow-md border border-gray-200"
                                :class="draggingCard && draggingCard.id === card.id ? 'opacity-50 scale-105' : ''"
                                draggable="true"
                                @dragstart="startDrag(column, card)"
                            >
                                <div class="font-medium mb-2 text-gray-800" x-html="card.title"></div>
                                <div class="text-sm text-gray-600 mb-2 line-clamp-2" x-html="card.content"></div>
                                <div class="flex justify-end mt-2">
                                    <span
                                        class="text-xs px-2 py-1 rounded-full font-medium"
                                        :class="{
                                            'bg-red-100 text-red-800': card.status === 'urgent',
                                            'bg-blue-100 text-blue-800': card.status === 'normal',
                                            'bg-gray-100 text-gray-800': card.status === 'pending',
                                            'bg-green-100 text-green-800': card.status === 'completed'
                                        }"
                                        x-text="card.status"
                                    ></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div class="flex justify-between mt-auto">
        <div>
            <p>{{ $currentDate }}</p>
        </div>
        <div>
            <p>A machin, apoco si</p>
        </div>
    </div>
</div>
