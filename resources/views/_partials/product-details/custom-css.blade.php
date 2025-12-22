<style>
    .pro-details-color-content ul li.disabled,
    .pro-details-size-content ul li.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pro-details-size-content ul li.disabled a {
        position: relative;
        display: inline-block;
    }

    .pro-details-size-content ul li.disabled a::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background: #999;
        transform: rotate(-20deg);
    }

    .pro-details-add-to-cart a.disabled {
        background-color: #a8a8a8;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pro-details-size-content ul li a.active {
        background-color: #333;
        color: #fff;
    }

    .easyzoom-style .easyzoom-flyout img {
        min-width: 100%;
        min-height: 100%;
    }
</style>