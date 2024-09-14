@php

use App\Helpers\IdGenerator;

/**
* @var string $value
* @var float $ratio
*/

$id = IdGenerator::generate();

@endphp

@once
<style>
    .image-input {
        width: 100%;
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        cursor: pointer;
    }
    .image-input::before {
        content: '';
        display: block;
        width: 100%;
        padding-top: {{ round(1 / $ratio * 100) }}%;
    }
    .image-input input {
        display: none;
    }
    .image-input img {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    .image-input_veil {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        color: #fff;
        font-size: 1.15rem;
        background-color: #00000055;
        backdrop-filter: blur(5px);
        transition: opacity 250ms;
        border-radius: 0.5rem;
    }
    .image-input:hover .image-input_veil {
        opacity: 1;
    }
</style>
@endonce

<label class="image-input" style="">
    <img src="{{ isset($value) && !empty($value) ? $value : '' }}" class="image-input_img" alt="Image">
    <input type="file" id="{{ $id }}" name="image" accept=".jpg, .jpeg, .png, .bmp, .webp">
    <span class="image-input_veil">{{ isset($placeholder) && !empty($placeholder) ? $placeholder : 'Choose image' }}</span>
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
