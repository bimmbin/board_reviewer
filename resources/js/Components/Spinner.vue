<template>
    <div class="flex items-center justify-center">
        <div class="p-1 loader">
            <div class="loader__circle"></div>
            <div class="loader__circle"></div>
            <div class="loader__circle"></div>
            <div class="loader__circle"></div>
            <div class="loader__circle"></div>
        </div>
    </div>
</template>

<style scoped>
.loader {
    position: relative;
    display: flex;
    gap: 0.3em;
}

.loader::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 2em;
    filter: blur(45px);
    background-image: radial-gradient(
            at 52% 57%,
            hsla(11, 83%, 72%, 1) 0px,
            transparent 50%
        ),
        radial-gradient(at 37% 57%, hsla(175, 78%, 66%, 1) 0px, transparent 50%);
}

.loader__circle {
    --size__loader: 0.5em;
    width: var(--size__loader);
    height: var(--size__loader);
    border-radius: 50%;
    animation: loader__circle__jumping 2s infinite;
    background-color: #ffffff;
}

.loader__circle:nth-child(2n) {
    animation-delay: 300ms;
    background-color: #a1ccff;
}

.loader__circle:nth-child(3n) {
    animation-delay: 600ms;
}

@keyframes loader__circle__jumping {
    0%,
    100% {
        transform: translateY(0px);
    }

    25% {
        transform: translateY(-15px) scale(0);
    }

    50% {
        transform: translateY(0px);
    }

    75% {
        transform: translateY(5px) scale(1);
    }
}
</style>
