<style>
    /*In Page Edit Button*/
    .multi-action {
        display: flex;
        flex-direction: column;
        position: fixed;
        left: 0px;
        top: 30%;
        cursor: pointer;
        z-index: 999;
        transition: all .4s;
    }
    .multi-action.show {
        left: 0;
    }
    .multi-action-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        width: 50px;
        background-color: var(--main-color-one);
        color: #fff;
        font-size: 24px;
        flex-shrink: 0;
        cursor: pointer;
    }
    .multi-action-inner {
        display: flex;
        flex-direction: column;
        padding: 10px 0;
        position: absolute;
        top: 100%;
        display: none;
    }
    .action-button {
        /*position: absolute;*/
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border: 0;
        outline: 0;
        background-color: var(--main-color-one);
        color: #fff;
        font-size: 24px;
        z-index: 2;
        /*box-shadow: 0 2px 10px 0 rgba(255, 38, 0, 0.15), 0 2px 5px 0 rgba(255, 53, 0, 0.12);*/
        transition: all 0.3s;
    }
    .action-button:not(:last-child) {
        margin-bottom: 10px;
    }

    .action-button span {
        transition: all 0.3s;
    }
    @media screen and (max-width: 991px) {
        .multi-action-icon {
            height: 40px;
            width: 40px;
            font-size: 20px;
        }
        .action-button {
            height: 40px;
            width: 40px;
            font-size: 20px;
        }
    }

</style>

<div class='multi-action'>
    <div class="multi-action-icon">
        <span class='las la-cog'></span>
    </div>
    <div class="multi-action-inner">
        <button class='action-button edit-page'
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                title="{{__('Edit page')}}">
            <span class='las la-edit'></span>
        </button>
{{--        <button class='action-button'>--}}
{{--            <span class='las la-edit'></span>--}}
{{--        </button>--}}
{{--        <button class='action-button'>--}}
{{--            <span class='las la-edit'></span>--}}
{{--        </button>--}}
    </div>
</div>

@php
    $route = $page_post->page_builder ? route(route_prefix().'admin.pages.builder', $page_post->id) : route(route_prefix().'admin.pages.edit', $page_post->id)
@endphp

<script>
    $redirectButton = document.querySelector('.edit-page');
    $redirectButton.addEventListener('click', function (){
        window.open('{{$route}}', '_blank');
    });
</script>
