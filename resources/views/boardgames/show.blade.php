{{-- resources/views/boardgames/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div id="boardgame-{{ $boardgame->acronym }}" class="main-boardgame container">
        @includeIf('boardgames.partials.' . $boardgame->acronym)
        @if ($boardgame->files->isNotEmpty())
            <button id="scroll-to-boardgame-file" class="btn btn-primary rounded-circle position-absolute start-50 translate-middle-x bottom-0 mb-3">
                <i class="bi bi-chevron-double-down fs-3"></i>
            </button>
        @endif
    </div>
    @if ($boardgame->files->isNotEmpty())
        <div id="boardgame-{{ $boardgame->acronym }}-file" class="main-boardgame-file container">
            <button id="scroll-to-boardgame" class="btn btn-secondary rounded-circle mb-5 w-auto mx-auto">
                <i class="bi bi-chevron-double-up fs-3"></i>
            </button>

            <h5 class="mb-3">Télécharger les fichiers</h5>

            <ul class="list-group">
                @foreach ($boardgame->files as $file)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                            {{ $file->display_name }}
                        </div>
                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="Télécharger">
                            <i class="bi bi-download"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection


@push('styles')
    @vite("resources/css/boardgames/{$boardgame->acronym}.css")
@endpush

@push('scripts')
    @if ($boardgame->files->isNotEmpty())
        <script>
        document.getElementById('scroll-to-boardgame-file').addEventListener('click', () => {
            document.getElementById('boardgame-{{ $boardgame->acronym }}-file').scrollIntoView({ behavior: 'smooth' });
        });

        document.getElementById('scroll-to-boardgame').addEventListener('click', () => {
            // document.getElementById('boardgame-{{ $boardgame->acronym }}').scrollIntoView({ behavior: 'smooth' });
            window.scrollTo({ top: 0, behavior: 'smooth'});
        });
        </script>
    @endif
    @vite("resources/js/boardgames/{$boardgame->acronym}.js")
@endpush