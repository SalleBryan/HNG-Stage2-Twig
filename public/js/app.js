// Theme Toggle
document.addEventListener("DOMContentLoaded", () => {
  // Initialize theme
  const savedTheme =
    localStorage.getItem("theme") || (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light")
  document.documentElement.setAttribute("data-theme", savedTheme)
  updateThemeButton(savedTheme)

  // Theme toggle button
  const themeToggle = document.getElementById("themeToggle")
  if (themeToggle) {
    themeToggle.addEventListener("click", () => {
      const currentTheme = document.documentElement.getAttribute("data-theme")
      const newTheme = currentTheme === "light" ? "dark" : "light"
      document.documentElement.setAttribute("data-theme", newTheme)
      localStorage.setItem("theme", newTheme)
      updateThemeButton(newTheme)
    })
  }

  function updateThemeButton(theme) {
    const button = document.getElementById("themeToggle")
    if (button) {
      button.textContent = theme === "light" ? "🌙" : "☀️"
      button.setAttribute("aria-label", `Switch to ${theme === "light" ? "dark" : "light"} mode`)
    }
  }

  // Auto-hide toast messages
  const toasts = document.querySelectorAll(".toast")
  toasts.forEach((toast) => {
    setTimeout(() => {
      toast.style.opacity = "0"
      setTimeout(() => toast.remove(), 300)
    }, 5000)
  })

  // Form loading states
  const forms = document.querySelectorAll("form[data-loading]")
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const submitBtn = this.querySelector('button[type="submit"]')
      if (submitBtn && !submitBtn.disabled) {
        const originalText = submitBtn.textContent
        const loadingText = submitBtn.getAttribute("data-loading-text") || "Loading..."
        submitBtn.textContent = loadingText
        submitBtn.disabled = true
      }
    })
  })
})

// Real-time form validation for signup
if (document.getElementById("signupForm")) {
  const nameInput = document.getElementById("name")
  const emailInput = document.getElementById("email")
  const passwordInput = document.getElementById("password")
  const confirmPasswordInput = document.getElementById("confirmPassword")

  function showError(input, message) {
    let errorDiv = input.nextElementSibling
    if (!errorDiv || !errorDiv.classList.contains("error-message")) {
      errorDiv = document.createElement("div")
      errorDiv.className = "error-message"
      errorDiv.style.cssText =
        "display: flex; align-items: center; gap: var(--space-xs); margin-top: var(--space-xs); color: var(--leaf-rust); font-size: var(--font-size-sm);"
      input.parentNode.insertBefore(errorDiv, input.nextSibling)
    }
    errorDiv.innerHTML = `
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
      </svg>
      <span>${message}</span>
    `
    input.setAttribute("aria-invalid", "true")
  }

  function clearError(input) {
    const errorDiv = input.nextElementSibling
    if (errorDiv && errorDiv.classList.contains("error-message")) {
      errorDiv.remove()
    }
    input.removeAttribute("aria-invalid")
  }

  nameInput?.addEventListener("blur", function () {
    const value = this.value.trim()
    if (!value) {
      showError(this, "Name is required")
    } else if (value.length < 2) {
      showError(this, "Name must be at least 2 characters")
    } else {
      clearError(this)
    }
  })

  emailInput?.addEventListener("blur", function () {
    const value = this.value.trim()
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!value) {
      showError(this, "Email is required")
    } else if (!emailRegex.test(value)) {
      showError(this, "Please enter a valid email address")
    } else {
      clearError(this)
    }
  })

  passwordInput?.addEventListener("blur", function () {
    const value = this.value
    if (!value) {
      showError(this, "Password is required")
    } else if (value.length < 6) {
      showError(this, "Password must be at least 6 characters")
    } else {
      clearError(this)
    }
  })

  confirmPasswordInput?.addEventListener("blur", function () {
    const value = this.value
    const password = passwordInput.value
    if (!value) {
      showError(this, "Please confirm your password")
    } else if (value !== password) {
      showError(this, "Passwords do not match")
    } else {
      clearError(this)
    }
  })

  passwordInput?.addEventListener("input", () => {
    if (confirmPasswordInput.value) {
      confirmPasswordInput.dispatchEvent(new Event("blur"))
    }
  })
}

// Ticket modal functions
function openCreateModal() {
  document.getElementById("modalTitle").textContent = "Create New Ticket"
  document.getElementById("ticketForm").action = "/tickets/create"
  document.getElementById("ticketId").value = ""
  document.getElementById("title").value = ""
  document.getElementById("description").value = ""
  document.getElementById("priority").value = "medium"
  document.getElementById("statusField").style.display = "none"
  document.getElementById("ticketModal").style.display = "flex"
  document.getElementById("title").focus()
}

function openEditModal(id, title, description, status, priority) {
  document.getElementById("modalTitle").textContent = "Edit Ticket"
  document.getElementById("ticketForm").action = "/tickets/update"
  document.getElementById("ticketId").value = id
  document.getElementById("title").value = title
  document.getElementById("description").value = description
  document.getElementById("priority").value = priority
  document.getElementById("status").value = status
  document.getElementById("statusField").style.display = "block"
  document.getElementById("ticketModal").style.display = "flex"
  document.getElementById("title").focus()
}

function closeModal() {
  document.getElementById("ticketModal").style.display = "none"
}

// Close modal on backdrop click
document.getElementById("ticketModal")?.addEventListener("click", function (e) {
  if (e.target === this) {
    closeModal()
  }
})

// Close modal on Escape key
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && document.getElementById("ticketModal")?.style.display === "flex") {
    closeModal()
  }
})
