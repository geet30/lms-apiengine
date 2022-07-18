
        <form id="ipFilter" name="ipFilter" accept-charset="UTF-8" class="submitIpWhitelist px-8 py-2">
            <div class="d-flex align-items-top position-relative gap-5 my-1">
                @csrf
                <div class="col-lg-6 ips">
                <textarea class="form-control form-control-solid h-45px" placeholder="e.g. 125.125.125.125 OR 125.125.125.125,130" name="ips"></textarea>
                <span class="error text-danger"></span>
                </div>
                <div class="col-lg-6 px-5" style="text-align:right;">
                <input type="hidden" value="{{request()->segment(2)}}" id="checksegment">
                <button type="submit" class="btn btn-light-primary">+Add</button>
                </div>
            </div>
        </form>


