document.addEventListener('alpine:init', () => {
    Alpine.data('inlineConfirmAction', ({ timeout, isGrouped = false }) => ({
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

        closeDropdown() {
            if (!isGrouped) return

            const dropdown = this.$el.closest('[x-data*="filamentDropdown"]')

            if (dropdown) {
                Alpine.$data(dropdown).close()
            }
        },
    }))
})
