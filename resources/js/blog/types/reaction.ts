import type { Emoji } from '@/blog/types/emoji'

export interface Reaction {
  id: number
  emoji: Emoji
}

export interface ReactionCount {
  id: number
  name: string
  emoji: string
  count: number
}
