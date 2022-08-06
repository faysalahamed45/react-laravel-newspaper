import React, { useState } from 'react';
import { useSelector } from 'react-redux';
import LatestRead from './LatestRead/LatestRead';
import TopRead from './TopRead/TopRead';
import Video from './Video/Video';
// import Video from './Video/Video';

const LatestAndVideo = () => {
	const [showContent,setShowContent]=useState(false)
	const {top_read, feature_post_2} = useSelector(
		(state) => state.homePost
);

// console.log(showContent);
// const togleContent = ()=>{
// 	setShowContent(!showContent)
// }
	return (
		<>
			<div className="container pt-2">
        <div className="row">
          <div className="col-xxl-3 col-xl-3 col-md-3 col-sm-12 col-12">
            <div className="number-container">
              <ul className="d-flex list-unstyled text-decoration-none">
                <li  onClick={()=>setShowContent(!showContent)}>
                 <label  className="cards-title-2">
                সর্বাধিক পঠিত
                 </label>
                    <span className={`${showContent ? "checkboxShow":"checkboxHide"}`} id="checkbox1-span"></span>
                </li>
                <li  onClick={()=>setShowContent(!showContent)}>
                  <label  className="cards-title-2">
                    রাজনীতি
                  </label>
                  <span className={`${showContent ? "checkboxHide":"checkboxShow"}`}  id="checkbox2-span"></span>
                </li>
                {/* <li id="checkbox3" onclick="showData(3)">
                  <label className="cards-title-2">
                    খেলা
                  </label>
                  <span id="checkbox3-span"></span>
                </li> */}
              </ul>
              <hr className="m-0 p-0"/>
            </div>

						<TopRead showContent={showContent}/>

						<LatestRead showContent={showContent}/>
            <div
              className="fourth-card-ad d-xxl-block d-xl-block d-md-block d-sm-none d-none"
            >
            <hr />
              <p
                className="d-flex justify-content-center align-items-center h-100 text-white"
              >
                Ads
              </p>
            </div>
          </div>
          <div className="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12">
            <hr
              className="d-xxl-none d-xl-none d-md-none d-sm-block d-block mb-0"
            />
            <p className="cards-title-2 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-3 pt-3">
              ভিডিও
            </p>
            <div className="row">
              <Video/>

              <div className="col-12">
                <div className="row">
                  <div className="col-6">
                    <div className="cards pb-3">
                      <a href="./html/Loading.html">
                        <div className="third-container-card overflow-hidden">
                          <img
                            className="img-fluid h-100"
                            src="../assets/image/image 3.png"
                            alt=""
                          />
                        </div>
                        <p className="cards-title-3 pt-3">
                          ভেঙেছে একটি বাঁধ, ফসলের ক্ষতির আশঙ্কা পাঁচটি হাওরে
                        </p>
                      </a>
                    </div>
                  </div>
                  <div className="col-6 third-container-card-sborder">
                    <div className="cards mb-3">
                      <a href="./html/Loading.html">
                        <div className="third-container-card overflow-hidden">
                          <img
                            className="img-fluid h-100"
                            src="../assets/image/image 4.png"
                            alt=""
                          />
                        </div>
                        <p className="cards-title-3 pt-3">
                          আগাম টিকিট বিক্রি শুরু সোমবার, বিশেষ সার্ভিস চালু ২৮
                          এপ্রিল
                        </p>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr />
      </div>
		</>
	);
};

export default LatestAndVideo;