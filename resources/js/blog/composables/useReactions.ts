import type { Reaction } from '@/blog/types/reaction'

const reactions = ref<Reaction[] | null>(null)

export function useReactions() {
  function fetchReactions(postId: number) {
    getUserPostReactions(postId).then(({ data }) => {
      reactions.value = data
    })
  }

  function toggleReaction(postId: number, emojiId: number) {
    console.log('Toggling reaction', postId, emojiId)
  }

  function isReacted(emojiId: number) {
    if (!reactions.value) {
      return false
    }

    return reactions.value.some(reaction => reaction.emoji.id === emojiId)
  }

  return {
    reactions: readonly(reactions),

    fetchReactions,
    toggleReaction,

    isReacted,
  }
}
