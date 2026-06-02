document.addEventListener('alpine:init', () => {
    Alpine.data('inlineConfirmAction', ({ timeout }) => ({
        armed: false,
        processing: false,
        timer: null,

        arm() {
            this.armed = true
            this.timer = setTimeout(() => this.disarm(), timeout)
        },

        disarm() {
            clearTimeout(this.timer)
            this.armed = false
            this.processing = false
        },

        process() {
            clearTimeout(this.timer)
            this.processing = true
        },
    }))
})
