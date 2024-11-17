import type { Toast } from '@/blog/types/toast'

const toasts = ref<Toast[]>([])

export function useToast() {
  function add(toast: Omit<Toast, 'id'>) {
    const newToast = {
      ...toast,
      id: Date.now(),
    }

    toasts.value.push(newToast)

    return newToast
  }

  function remove(toast: Toast) {
    const index = toasts.value.indexOf(toast)

    if (index === -1) {
      return
    }

    setTimeout(() => {
      toasts.value = toasts.value.filter((t: Toast) => t.id !== toast.id)
    }, 300)
  }

  return {
    toasts: readonly(toasts),

    add,
    remove,
  }
}
