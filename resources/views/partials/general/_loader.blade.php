<div id="custom_loader" style="display: none;" class="loading">Loading&#8230;</div>
@section('styles')
    <link href="/custom/css/loader.css" rel="stylesheet" type="text/css"/>
@endsection

<script>
    const Loader = function (options) {

        const loader = document.getElementById('custom_loader')

        this.show = function () {
            loader.style.display = 'block'
        }

        this.hide = function () {    
            loader.style.display = 'none'
        };
        
    };

    const loaderInstance = new Loader

</script>    
