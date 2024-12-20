export interface Toast {
  id: number

  title: string
  description: string

  type?: 'success' | 'error' | 'info' | 'trash' | 'warning'
  customIconText?: string
}
