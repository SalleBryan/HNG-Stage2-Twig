// Auto-hide flash messages after 5 seconds
document.addEventListener("DOMContentLoaded", () => {
  const toasts = document.querySelectorAll(".toast")
  toasts.forEach((toast) => {
    setTimeout(() => {
      toast.style.opacity = "0"
      setTimeout(() => toast.remove(), 300)
    }, 5000)
  })
})
