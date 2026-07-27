<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<!-- asset plugin datatables -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.js"></script>

<!-- load fontawesome with cdn -->
<script src="https://kit.fontawesome.com/96224fff9f.js" crossorigin="anonymous"></script>

<!-- load ckeditor cdn -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        if (typeof CKEDITOR !== 'undefined' && document.getElementById('alamat')) {
            CKEDITOR.replace('alamat', {
                filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
                filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageBrowseUrl: 'assets/ckfinder/ckfinder.html?type=Images',
                filebrowserImageUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
            });
        }
        if (document.getElementById('mahasiswaTable')) {
            $('#mahasiswaTable').DataTable();
        }
        if (document.getElementById('barangTable')) {
            $('#barangTable').DataTable();
        }
        if (document.getElementById('akunTable')) {
            $('#akunTable').DataTable();
        }
    });
</script>
</body>

</html>