
<!-- Delete Model -->
<form action="" method="POST" class="remove-record-model">
    @method('DELETE')
    @csrf
    <div id="custom-width-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Elem törlése</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-content">
                        <h5 class="text-center">Biztos törölni szeretné <span id="itemname"></span> <span id="name"></span> elemet?</h5>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="btnClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                    <button type="submit" class="btn btn-danger">Igen, Törlés</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).on('click','.remove-record',function(){
        let id = $(this).attr('data-id');
        $('#id').val(id);

        // For A Delete Record Popup
        var url = $(this).attr('data-url');
        
        $(".remove-record-model").attr("action",url);
		$('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
        
        function isVowel(word) {
            let letter = word.charAt(0);
            let vowels = ["a", "á", "e", "é", "i", "í", "o", "ó", "ö", "ő", "u", "ú", "ü", "ű", "y", "A", "Á", "E", "É", "I", "Í", "O", "Ó", "Ö", "Ő", "U", "Ú", "Ü", "Ű", "Y"];
            return vowels.includes(letter);
        }
        
        $.get('/{{$routeurl}}/' + id + '/modal', function (data) {
            let art = isVowel(data.data.{{$name}}) ? 'az' : 'a';
            $('#itemname').html(art);
            $('#name').html(data.data.{{$name}});
        });
    });
</script>