export function useEmoji() {
  return useQuery({
    key: ['emoji', window.postId],
    query: () => getEmoji(window.postId),
  })
}
