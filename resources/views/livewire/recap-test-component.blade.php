<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <h1>Texto directo de Blade: {{ $testTitle }}</h1>
    <p>Contenido directo: {{ $testContent }}</p>

    <hr>

    <div x-data="{
        title: @js($testTitle),
        content: @js($testContent)
    }">
        <h2>Texto via Alpine: <span x-text="title"></span></h2>
        <p>Contenido via Alpine: <span x-text="content"></span></p>
    </div>
</div>
