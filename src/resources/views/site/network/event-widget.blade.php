<div class="widget-card">

    <h3 class="widget-title">
        Próximos Eventos
    </h3>

    @forelse($eventos as $evento)

        <div class="event-item">

            <h4>

                {{ $evento->titulo_evento }}

            </h4>

            <p>

                {{ $evento->data_inicial_evento }}

            </p>

        </div>

    @empty

        <p>
            Nenhum evento disponível.
        </p>

    @endforelse

</div>