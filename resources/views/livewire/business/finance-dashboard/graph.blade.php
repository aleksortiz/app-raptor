<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Graph</h4>
        </div>
        <div class="card-body">
            {{$this->viewGraph}}
            <button class="btn btn-primary" wire:click="clickGraph">Get Graph</button>
            <div class="chart">
                <canvas id="chartdiv" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
