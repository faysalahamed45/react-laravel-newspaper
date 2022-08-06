import React, { useEffect, useState } from 'react'
import SearchBar from './SearchBar'
import youtube from '../apis/youtube'
import VideoList from './VideoList'
import VideoDetail from './VideoDetail'

const VideoMain =() => {
 const [vidoItem,setVideoItem]= useState({ videos: [], selectedVideo: null });
  // state = { videos: [], selectedVideo: null }

  useEffect(()=>{
   onTermSubmit('jazzy')
  })
  // componentDidMount() {
  //   this.onTermSubmit('jazzy')
  // }
  // console.log(state.videos);
  const onTermSubmit = async (term) => {
    const response = await youtube.get('/search', {
      params: {
        q: term,
      },
    })

    setVideoItem({
      videos: response.data.items,
      selectedVideo: response.data.items[0],
    })
  }

  const onVideoSelect = (video) => {
   setVideoItem({ selectedVideo: video })
  }


  
    return (
      <div className="ui container" style={{ marginTop: '30px' }}>
        <SearchBar onFormSubmit={onTermSubmit} />
        <div className="ui grid">
          <div className="ui row">
            <div className="eleven wide column">
              <VideoDetail video={vidoItem.selectedVideo} />
            </div>
            <div className="five wide column">
              <VideoList
                onVideoSelect={onVideoSelect}
                videos={vidoItem.videos}
              />
            </div>
          </div>
        </div>
      </div>
    )
}

export default VideoMain
