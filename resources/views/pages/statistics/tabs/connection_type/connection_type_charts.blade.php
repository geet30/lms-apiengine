<div class="pb-5 pt-3">
    <div class="card shadow-sm">
        <div class="card-header collapsible cursor-pointer rotate collapsed" data-bs-toggle="collapse"
            data-bs-target="#connection_type_charts_collapsible" id="connection_click">
            <h3 class="card-title">Connection Type</h3>
            <div class="card-toolbar rotate-180">
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)"
                            fill="currentColor"></rect>
                        <path
                            d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div id="connection_type_charts_collapsible" class="collapse">
            {{ theme()->getView('pages/statistics/tabs/connection_type/toolbar', ['chartType' => 'connection_type_charts', 'services' => $services]) }}
            <div class="card-body">
                <div class="card card-bordered">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 connection_title m-auto fw-bold">Connection Type Graph</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 connection_stat_title m-auto fw-bold"></div>
                        </div>
                        <div id="connection_type_charts" style="height: 350px; overflow:scroll;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
