import { GrAppleAppStore } from 'react-icons/gr'
import { HiOutlineBookOpen } from 'react-icons/hi'
import { SiApple, SiAppstore } from 'react-icons/si'
import { BiPodcast } from 'react-icons/bi'

export const StoreIcon = (props) => {
  switch (props.type) {
    case 'app':
      return (
        <>
          <SiAppstore />
          <span className="wpalb-btn-label">App Store</span>
        </>
      )
    case 'mac-app':
      return (
        <>
          <SiAppstore />
          <span className="wpalb-btn-label">Mac App Store</span>
        </>
      )

    case 'movie':
      return (
        <>
          <SiApple />
          <span className="wpalb-btn-label">TV</span>
        </>
      )

    case 'ebook':
    case 'audiobook':
      return (
        <>
          <HiOutlineBookOpen />
          <span className="wpalb-btn-label">Apple Books</span>
        </>
      )

    case 'podcast':
      return (
        <>
          <BiPodcast />
          <span className="wpalb-btn-label">Apple Podcast</span>
        </>
      )

    case 'music-track':
    case 'music-album':
    case 'music-video':
      return (
        <>
          <SiApple />
          <span className="wpalb-btn-label">Music</span>
        </>
      )

    default:
      return (
        <>
          <GrAppleAppStore />
          <span className="wpalb-btn-label">App Store</span>
        </>
      )
  }
}