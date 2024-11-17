import type { Reaction } from '@/blog/types/reaction'

const reactions = ref<Reaction[] | null>(null)

export function useReactions() {
  function fetchReactions(postId: number) {
    getUserPostReactions(postId).then(({ data }) => {
      reactions.value = data
    })
  }

  const { add } = useToast()
  const { emoji } = useEmoji()
  function toggleReaction(postId: number, emojiId: number) {
    /**
     * Mettre à jour l'interface utilisateur
     * Faire la transaction avec l'API
     * Success: afficher une notification
     * Error: afficher une notification et rollback l'interface utilisateur
     */

    const reacted = isReacted(emojiId)

    if (reacted) {
      const reaction = reactions.value?.find(reaction => reaction.emoji.id === emojiId)

      if (!reaction) {
        return
      }

      // Remove reaction
      reactions.value = reactions.value?.filter(reaction => reaction.emoji.id !== emojiId) || []

      emoji.value = emoji.value?.map((e) => {
        if (e.id === emojiId) {
          e.count--
        }

        return e
      }) || []

      deleteReaction(postId, reaction.id).then(() => {
        add({
          type: 'success',
          title: 'Reaction removed',
          description: 'Your reaction has been removed successfully',
        })
      }).catch(() => {
        // Rollback
        reactions.value = [...(reactions.value || []), reaction]

        emoji.value = emoji.value?.map((e) => {
          if (e.id === emojiId) {
            e.count++
          }

          return e
        }) || []

        add({
          type: 'error',
          title: 'Error',
          description: 'An error occurred while removing your reaction',
        })
      })
    }
    else {
      // Add reaction
      reactions.value = [...(reactions.value || []), { emoji: { id: emojiId, name: '', emoji: '' }, id: -1 }]

      emoji.value = emoji.value?.map((e) => {
        if (e.id === emojiId) {
          e.count++
        }

        return e
      }) || []

      storeReaction(postId, emojiId).then(({ data }) => {
        reactions.value = reactions.value?.map((reaction) => {
          if (reaction.emoji.id === emojiId) {
            return data
          }

          return reaction
        }) || []

        add({
          type: 'success',
          title: 'Reaction added',
          description: 'Your reaction has been added successfully',
        })
      }).catch(() => {
        // Rollback
        reactions.value = reactions.value?.filter(reaction => reaction.emoji.id !== emojiId) || []

        emoji.value = emoji.value?.map((e) => {
          if (e.id === emojiId) {
            e.count--
          }

          return e
        }) || []

        add({
          type: 'error',
          title: 'Error',
          description: 'An error occurred while adding your reaction',
        })
      })
    }
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
