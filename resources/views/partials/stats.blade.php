<div class="stats-bar">
    <div class="container">
        <div class="row g-4 text-center">
            @foreach([
                ['10+',  'Years in Business'],
                ['200+', 'Clients Served'],
                ['50+',  'Team Members'],
                ['98%',  'Client Satisfaction'],
            ] as [$num, $desc])
            <div class="col-6 col-md-3 stat-item">
                <div class="num">{{ $num }}</div>
                <div class="desc">{{ $desc }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>