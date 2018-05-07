export default {
  name: 'countdown',
  data() {
    return {
      endDate: 1527811201000,
      days: null,
      hours: null,
      minutes: null,
      message: null,
      interval: null,
      running: false,
    }
  },

  mounted() {
    this.calculateCountdown()

    this.interval = setInterval(() => {
      this.calculateCountdown()
    }, 1000)
  },

  methods: {
    calculateCountdown() {
      const now = new Date().getTime()
      const distance = this.endDate - now

      if (distance < 0) {
        // countdown ended
        this.message = true
        clearInterval(this.interval)

        return
      }

      // set countdown
      this.running = true
      this.days = Math.floor(distance / (1000 * 60 * 60 * 24))
      this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
      this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
    },
  },
}
