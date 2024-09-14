@php

use App\Helpers\IdGenerator;

$id = IdGenerator::generate();

@endphp

<label class="profile_avatar_wrap" style="">
    <img src="{{ isset($value) && !empty($value) ? $value : '' }}" class="profile_avatar" alt="User avatar">
    <input type="file" style="display: none" id="{{ $id }}" name="photo" accept=".jpg, .jpeg, .png, .bmp, .webp">
</label>

<script>
    (() => {
        let imageInput = document.getElementById('{{ $id }}');

        imageInput.addEventListener('change', function () {
            let reader = new FileReader();
            reader.onload = () => imageInput.parentNode.querySelector('img').src = reader.result;
            reader.readAsDataURL(imageInput.files[0]);
        });
    })();
</script>
