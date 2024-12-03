<!-- Include jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Popper.js (for Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

<!-- Include Bootstrap JS (for Summernote) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Jquery Core Js -->
<script src="{{asset('/')}}admin/assets/bundles/libscripts.bundle.js"></script>

<!-- Plugin Js-->
<script src="{{asset('/')}}admin/assets/bundles/apexcharts.bundle.js"></script>
<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-example').select2({
            dropdownParent: $('body'), // Make sure dropdown appears outside modal
            placeholder: "Search and select an option",
            allowClear: true
        });
    });
</script>
<!-- Jquery Page Js -->
<script src="{{asset('/')}}admin/assets/js/template.js"></script>
<script src="{{asset('/')}}admin/assets/js/page/hr.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

{!! Toastr::message() !!}

<script>
    toastr.options = {
        "progressBar" : true,
        "closeButton" : true,
    }
    @if(Session::has('message'))
    toastr.success("{{ Session::get('message') }}");

    @elseif(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");

    @elseif(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");

    @elseif(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif
</script>
{{--<script src="https://kit.fontawesome.com/1b84ef290f.js" crossorigin="anonymous"></script>--}}
@stack('js')
<script src="{{asset('/')}}fontawesome/js/all.js" crossorigin="anonymous"></script>

<!-- DATA TABLE JS-->
<script src="{{asset('/')}}datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}datatable/js/dataTables.bootstrap5.js"></script>
<script src="{{asset('/')}}datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/')}}datatable/js/buttons.bootstrap5.min.js"></script>
<script src="{{asset('/')}}datatable/js/jszip.min.js"></script>
<script src="{{asset('/')}}datatable/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('/')}}datatable/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('/')}}datatable/js/buttons.html5.min.js"></script>
<script src="{{asset('/')}}datatable/js/buttons.print.min.js"></script>
<script src="{{asset('/')}}datatable/js/buttons.colVis.min.js"></script>
<script src="{{asset('/')}}datatable/dataTables.responsive.min.js"></script>
<script src="{{asset('/')}}datatable/responsive.bootstrap5.min.js"></script>
<script src="{{asset('/')}}datatable/table-data.js"></script>
{{--<script>
    $(document).ready(function() {
        $(document).on('change', '.image-input', function(event) {
            // let inputId = $(this).attr('id');
            let previewId = '#imagePreview'/* + inputId*/;
            console.log(inputId,previewId);
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>--}}
