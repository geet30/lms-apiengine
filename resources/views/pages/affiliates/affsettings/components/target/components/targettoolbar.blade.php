<div class="card-header align-items-center border-0">
    <div class="card-title">
        <form id="targetFilter" name="targetFilter" accept-charset="UTF-8" class="" method="POST">
            <div class="d-flex align-items-center position-relative gap-1 my-1">
                @csrf
                <select id="sort_month" class="form-control CommonRepository form-control-solid form-select w-150px resetvalues" data-control="select2" name="sort_month" data-placeholder="Select Month">
                    <option value="" selected=" selected">Select Month</option>
                    @for ($i = 1; $i <= 12; $i++) @php $month=date('F', mktime(0, 0, 0, $i, 10)); @endphp <option value="{{ $i }}" @if(isset($searchValues['sort_month']) && $searchValues['sort_month']==$i) selected @endif>
                        {{ $month }}</option>
                        @endfor
                </select>

                <select id="sort_year" data-control="select2" class="form-control form-control-solid CommonRepository form-select w-150px resetvalues" name="sort_year" data-placeholder="Select Year">
                    <option value="">Select Year</option>
                    <option value="{{\Carbon\Carbon::now()->format('Y')}}" @if(isset($searchValues['sort_year']) && $searchValues['sort_year']==\Carbon\Carbon::now()->format('Y')) selected @endif>{{\Carbon\Carbon::now()->format('Y')}}</option>
                    <option value="{{\Carbon\Carbon::now()->addYear()->format('Y')}}" @if(isset($searchValues['sort_year']) && $searchValues['sort_year']==\Carbon\Carbon::now()->addYear()->format('Y')) selected @endif>{{\Carbon\Carbon::now()->addYear()->format('Y')}}</option>
                </select>

                <select id="status_sort_type" data-control="select2" class="form-control form-control-solid form-select w-150px resetvalues" name="status_sort_type" data-placeholder="Target Status">
                    <option value="" selected="selected">Target Status</option>
                    <option value="0" @if(isset($searchValues['status_sort_type']) && $searchValues['status_sort_type']==0) selected @endif>Not Achieved</option>
                    <option value="1" @if(isset($searchValues['status_sort_type']) && $searchValues['status_sort_type']==1) selected @endif>Achieved</option>
                </select>
                <button type="submit" class="btn btn-primary submitTarget">{{ __('affiliates_label.buttons.apply') }}</button>

            </div>
        </form>
    </div>
    <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="set_target_btn" data-bs-target="#settargetmodel" data-user_id="">{{ __('affiliates_label.buttons.set_target') }}</button>
        <button type="button" class="btn btn-light-primary" id="export_target">
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black" />
                    <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black" />
                    <path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4" />
                </svg>
            </span>
            {{ __('affiliates_label.buttons.export') }}</button>

        <button type="button" class="btn btn-primary resetTarget">{{ __('affiliates_label.buttons.reset') }}</button>


    </div>
</div>