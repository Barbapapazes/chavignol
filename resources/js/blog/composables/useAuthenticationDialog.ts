const isOpened = ref(false)

export function useAuthenticationDialog() {
  function open() {
    isOpened.value = true
  }

  function close() {
    isOpened.value = false
  }

  return {
    isOpened: readonly(isOpened),

    open,
    close,
  }
}
