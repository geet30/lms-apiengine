
<?php $i=1;?>
@foreach ($rateLimits as $limit)

<tr>
    <td>{{$i++}}</td>
    <td>{{$limit->limit_type}}</td>
    <td>{{getLimitLevel($limit->limit_level)}}</td>
    <td>{{$limit->limit_daily}}</td>
    <td>{{$limit->limit_charges}}</td>
    <td>
        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions

            <span class="svg-icon svg-icon-5 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                </svg>
            </span>

        </a>

        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">

            <div class="menu-item px-3">

                <button type="button" class="btn me-3" data-bs-toggle="modal" data-id="{{$limit->id}}" data-type="{{$limit->limit_type}}"data-level="{{$limit->limit_level}}" data-daily="{{$limit->limit_daily}}" data-charges="{{$limit->limit_charges}}"data-year="{{$limit->limit_year}}" data-desc="{{$limit->limit_desc}}" data-desc2="{{$limit->limit_charges_description}}" class="edit_limit" data-bs-target="#add_plan_rate_modal">
                    {{ __('plans/energyPlans.edit') }}
                </button>
                <button type="button" class="btn me-3" data-bs-toggle="modal" data-bs-target="">
                    {{ __('plans/energyPlans.delete') }}
                    </button>



            </div>

        </div>

    </td>
</tr>

@endforeach

