document.addEventListener('alpine:init', () => {
    Alpine.data('inlineConfirmAction', ({ timeout, isGrouped = false, shouldCloseDropdown = true }) => ({
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
            this.closeDropdown()
        },

        closeDropdown() {
            if (!isGrouped || !shouldCloseDropdown) return

            const dropdown = this.$el.closest('[x-data*="filamentDropdown"]')

            if (dropdown) {
                Alpine.$data(dropdown).close()
            }
        },
    }))

    Alpine.data('holdToConfirmAction', ({ duration, isGrouped = false, shouldCloseDropdown = true }) => ({
        holding: false,
        processing: false,
        timer: null,

        start() {
            if (this.processing) return

            this.holding = true
            this.timer = setTimeout(() => this.complete(), duration)
        },

        cancel() {
            if (!this.holding || this.processing) return

            clearTimeout(this.timer)
            this.holding = false
        },

        complete() {
            clearTimeout(this.timer)
            this.holding = false
            this.processing = true

            this.closeDropdown()

            this.$el.dispatchEvent(new CustomEvent('htc-complete', { bubbles: true }))
        },

        done() {
            this.processing = false
        },

        closeDropdown() {
            if (!isGrouped || !shouldCloseDropdown) return

            const dropdown = this.$el.closest('[x-data*="filamentDropdown"]')

            if (dropdown) {
                Alpine.$data(dropdown).close()
            }
        },
    }))
})
