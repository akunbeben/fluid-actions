document.addEventListener('alpine:init', () => {
    Alpine.data('inlineConfirmAction', ({ timeout, confirm }) => ({
        armed: false,
        timer: null,

        arm() {
            this.armed = true
            this.timer = setTimeout(() => this.disarm(), timeout)
        },

        confirm() {
            clearTimeout(this.timer)
            this.armed = false
            confirm()
        },

        disarm() {
            clearTimeout(this.timer)
            this.armed = false
        },
    }))
})
