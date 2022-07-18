/*
 * BreadCrumbs Functionality
 */
const BreadCrumbs = function (options,header) {

    /*
     * Variables accessible
     * in the class
     */
    let params = (new URL(document.location)).searchParams;
    var vars = {
      mode: params.get("mode"),
      items: {},
      header: ''
    };
  
    /*
     * Can access this.method
     * inside other methods using
     * root.method()
     */
    var root = this;
  
    /*
     * Constructor
     */
    this.construct = function (options,header) {
      $.extend(vars.items, options); 
      vars.header = header
    };
  
    /*
     * Public method for set BreadCrumbs 
     */
    this.init = function () {
        root.setBreadCrumbs()
    };
  
    /*
     *  Set BreadCrumbs 
     */
    this.setBreadCrumbs = function  () { 
        let listHTML = '';
        let listClasses = ['breadcrumb-item'];

        $('#breadcrumbs_custom_title').html(vars.header) 
        if (typeof vars.header == 'undefined' && Object.keys(vars.items).length >= 2) { 
            $('#breadcrumbs_custom_title').html(vars.header)
        } 
        
        $.each(vars.items, function (i, val) {
            if (val.active) {
                listClasses.push('active text-dark');
            }

            listHTML += '<li class="'+  listClasses.join(' ') +'">'
            if (!val.active) {
                if (vars.mode) {
                    val.link = val.link + '?mode=' + vars.mode
                }
                listHTML += '<a href="'+ val.link +'">'+ val.title +'</a>'
            } else {
                listHTML += val.title
            }
            
            listHTML += '</li>';
        });
        
        $('#custom_id_for_custom_breadcrumbs').html(listHTML);
    };
  
  
    /*
     * Pass options when class instantiated
     */
    this.construct(options,header);
  
  };
  