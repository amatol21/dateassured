<?php
/**
 * @var array $options
 *
 * $options = [
 *     'delete-user' => ['label' => 'Delete user', 'payload' => 1],
 *     'ban-user' => ['label' => 'Ban user', 'payload' => 1],
 *     ...
 * ];
 *
 */
?>

@once
<style>
    .dots-menu {
        width: 2rem;
        height: 3rem;
        position: relative;
    }
    .dots-menu_dots {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        position: relative;
        cursor: pointer;
        border-radius: 0.25rem;
    }
    .dots-menu.active  .dots-menu_dots {
        background-color: #f3f3f3;
    }
    .dots-menu_dot {
        width: 0.25rem;
        height: 0.25rem;
        border-radius: 0.5rem;
        background-color: #ccc;
    }
    .dots-menu_dot:nth-child(2),
    .dots-menu_dot:nth-child(3) {
        margin-top: 0.25rem;
    }
    .dots-menu:hover .dots-menu_dot,
    .dots-menu.active .dots-menu_dot {
        background-color: #999;
    }
    .dots-menu_options {
        display: none;
        opacity: 0;
        flex-direction: column;
        position: fixed;
        background-color: #fff;
        border-radius: 0.25rem;
        width: 10rem;
        z-index: 5;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.03), 0 10px 7px rgba(0, 0, 0, 0.08), 0 15px 32px rgba(0, 0, 0, 0.13);
        margin-left: -8rem;
        border: 1px solid #ccc;
    }
    .dots-menu_options.arrow-up::before {
        content: '';
        display: block;
        width: 1rem;
        height: 1rem;
        border-radius: 2px;
        background-color: #fff;
        transform: rotate(45deg);
        position: absolute;
        top: -0.5rem;
        right: 0.4rem;
        border: 1px solid #ccc;
    }
    .dots-menu_options.arrow-down::before {
        content: '';
        display: block;
        width: 1rem;
        height: 1rem;
        border-radius: 2px;
        background-color: #fff;
        transform: rotate(45deg);
        position: absolute;
        bottom: -0.5rem;
        right: 0.4rem;
        border: 1px solid #ccc;
    }
    .dots-menu_option {
        padding: 0.5rem 0.5rem;
        font-size: 0.85rem;
        background-color: #fff;
        z-index: 2;
        cursor: pointer;
    }
    .dots-menu_option:hover {
        background-color: #f3f3f3;
    }
    .dots-menu_option:first-child {
        border-radius: 0.25rem 0.25rem 0 0;
    }
    .dots-menu_option:last-child {
        border-radius: 0 0 0.25rem 0.25rem;
    }
    .dots-menu_option + .dots-menu_option {
        /*border-top: 1px solid #eee;*/
    }
</style>
@endonce

<div class="dots-menu" onclick="event.stopPropagation()">
    <div class="dots-menu_dots" onclick="document.dispatchEvent(new CustomEvent('dots-menu-open', {detail: this}))">
        <div class="dots-menu_dot"></div>
        <div class="dots-menu_dot"></div>
        <div class="dots-menu_dot"></div>
    </div>
    <div class="dots-menu_options">
        @foreach($options as $event => $option)
            <div class="dots-menu_option"
                onclick="
                    document.dispatchEvent(new CustomEvent('dots-menu-hide', {detail: this}));
                    document.dispatchEvent(new CustomEvent('{{ $event }}', {detail: {{ json_encode($option['payload']) }}}));
            ">{{ $option['label'] }}</div>
        @endforeach
    </div>
</div>

@once
<script>
	(() => {
		async function hideMenu(menu) {
			let activeOptions = menu.querySelector('.dots-menu_options');
			menu.classList.remove('active');
			await animate(k => activeOptions.style.opacity = (1 - k).toString(), 150);
			activeOptions.style.display = null;
		}

		// Show options when user clicks on menu dots.
		document.addEventListener('dots-menu-open', async e => {
			let menu = e.detail.parentNode;
			//console.log(e);
			let options = menu.querySelector('.dots-menu_options');
			let rect = e.detail.getBoundingClientRect();
			options.style.opacity = '0';
			options.style.display = 'flex';

			let activeMenu = document.querySelector('.dots-menu.active');
			if (activeMenu !== null) hideMenu(activeMenu);

			menu.classList.add('active');
			options.style.left = rect.right - rect.width + 'px';
			if (rect.top > window.innerHeight - 300) {
				options.classList.remove('arrow-up');
				options.classList.add('arrow-down');
				options.style.top = null;
				options.style.bottom = window.innerHeight - rect.bottom + rect.height + 5 + 'px';
			} else {
				options.classList.add('arrow-up');
				options.classList.remove('arrow-down');
				options.style.bottom = null;
				options.style.top = rect.top + rect.height + 5 + 'px';
			}
			await animate(k => {
				options.style.opacity = k.toString();
			}, 150);
		});

		// Hide active menu when user clicks any option.
		document.addEventListener('dots-menu-hide', e => {

			hideMenu(e.detail.parentNode.parentNode);
		});

		// Hide active menu when user clicks outside the menu.
		document.addEventListener('click', () => {
			let activeMenu = document.querySelector('.dots-menu.active');
			if (activeMenu !== null) hideMenu(activeMenu);
		});
	})();
</script>
@endonce
