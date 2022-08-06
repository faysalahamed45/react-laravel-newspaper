import React, { useState } from "react";
import "./video.css";
import video1 from "./video1.mp4";
import video2 from "./video2.mp4";

const Video = () => {
  const [showVideo, setShowVideo] = useState({ src: null, title: null });

  const changeVideo = (e) => {
    e.preventDefault();
    if (e.target.classList[0] == "vid") {
      setShowVideo({
        src: e.target.children[0].currentSrc,
        title: e.target.children[1].innerHTML,
      });
    }

    // console.log(showVideo);
    else if (e.target.classList[0] == "video") {
      setShowVideo({
        src: e.target.parentElement.children[0].currentSrc,
        title: e.target.nextElementSibling.innerHTML,
      });
    }
    if (e.target.classList[0] == "title") {
      setShowVideo({
        src: e.target.parentElement.children[0].currentSrc,
        title: e.target.outerText,
      });
    }
  };

  return (
    <div>
      <h3 className="heading">video gallery</h3>
      <div className="container">
        <div className="main-video">
          <div className="video">
            <video src={showVideo.src} controls muted autoPlay></video>
            <h3 className="title">{showVideo.title}</h3>
          </div>
        </div>
        <div className="video-list">
          <div onClick={changeVideo} className="vid active">
            <video className="video" src={video1} muted></video>
            <h3 className="title">01 video title goes here</h3>
          </div>
          <div onClick={changeVideo} className="vid">
            <video className="video" src={video2} muted></video>
            <h3 className="title">02 video title goes here</h3>
          </div>
          <div onClick={changeVideo} className="vid">
            <video className="video" src={video1} muted></video>
            <h3 className="title">03 video title goes here</h3>
          </div>
          <div onClick={changeVideo} className="vid">
            <video className="video" src={video2} muted></video>
            <h3 className="title">04 video title goes here</h3>
          </div>
          <div onClick={changeVideo} className="vid">
            <video className="video" src={video1} muted></video>
            <h3 className="title">05 video title goes here</h3>
          </div>
          <div className="vid">
            <video className="video" src={video2} muted></video>
            <h3 className="title">06 video title goes here</h3>
          </div>
          <div className="vid">
            <video className="video" src={video1} muted></video>
            <h3 className="title">07 video title goes here</h3>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Video;
