<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <!-- Memanggil session -->
    <!-- Meta Section -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Meta CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/sb-admin-2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Stylesheet Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

    <!-- Iconscout CDN Link Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <!-- cdn jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title> @yield('title') | Laboratory Information System</title>
</head>


<body>
  <div id="wrapper">
    <!-- Sidebar -->
    <!-- @include('partials.sidebar') -->
    @include('partials.sidebar')
    <!-- End sidebar -->

    <section class="home-section ">
        <!-- Navbar -->
        @include('partials.navbar')
        <!-- End Navbar -->

        <!-- Content -->
        @yield('content')
        <!-- End Content -->
    </section>
  </div>

  @yield('modal')

{{--
  <!-- Ajax-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}

  <!-- Tambahkan Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script src="{{ asset('js/script-sidebar.js') }}"></script>
  <script src="{{ asset('js/pemeriksaan.js') }}"></script>
  <script src="{{ asset('bootstrap/js/sb-admin-2.js') }}"></script>
  <script src="{{ asset('bootstrap/js/sb-admin-2.min.js') }}"></script>
  {{-- <script src="{{ asset('bootstrap/vendor/jquery/jquery.min.js') }}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="{{ asset('bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('bootstrap/vendor/jquery-easing/jquery.easing.min.js') }}"></script>


  @include('sweetalert::alert')
  {{-- <script src="{{ asset('js/loket.js') }}"></script> --}}


  <script src="{{ asset('../js/ak.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function(){

        var html = '<div class="form-group col-12 col-md-9 row mt-2" id="tambah-field-lain"><input type="text" class="form-control col-md-11" value="" id="" name="pemeriksaan-lain-lain[]" placeholder="Ketik Tambahan"><div class="col-md-1"><input type="button" class="btn btn-danger" value="-" id="remove"></div>';

        var x = 1;

        $("#add-lain").click(function(){
            $("#child-pemeriksaan-lain").append(html);
        });

        $("#child-pemeriksaan-lain").on('click','#remove',function(){
            $(this).closest('#tambah-field-lain').remove();
        });

    });
</script>

<!-- diagnosa dipanggil dengan select2 dari database icd10 -->
<script>
    $(document).ready(function() {
        $('#diagnosa').select2({
            placeholder: 'Pilih Diagnosa',
            ajax: {
                url: '{{ route('geticd10') }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                    results:  $.map(data, function (item) {
                        return {
                        text: item.code + ' - ' + item.name_id,
                        id: item.code
                        }
                    })
                    };
                },
                cache: true
            }
        });
    });
</script>



<!-- autofill -->
{{-- <script>
    $(document).ready(function() {
        $('#diagnosa').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('geticd10') }}",
                    method: "GET",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#diagnosaList').fadeIn();
                        $('#diagnosaList').html(data);
                    }
                });
            }
        });
    });
</script> --}}

</body>
</html>
