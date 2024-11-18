import type { ReactionCount } from '@/blog/types/reaction'
import type { Resource } from '@/blog/types/resource'

export function getEmoji(postId: number) {
  return baseApi<Resource<ReactionCount[]>>(`/api/posts/${postId}/reactions`, {
    method: 'GET',
  })
}
