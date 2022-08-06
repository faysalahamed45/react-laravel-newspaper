import React from "react";
import { useSelector } from "react-redux";
import { Link } from "react-router-dom";
import MomentTo from "../../../MomentJs/MomentTo";

const ExclusiveAndLatest = () => {
	const {exclusive,latest_post} = useSelector(
		(state) => state.homePost);
		// console.log(object);
    return (
        <div>
            <div className="container">
                <div className="row">
                    <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12">
                        <p className="cards-title-2">এক্সক্লুসিভ</p>
                        {exclusive?.slice(0, 1).map((postContent) => {
                            return(
                                <Link
																   key={postContent.id}
                                    className="text-decoration-none"
                                    to={`/${postContent?.slug_bn}`}
                                >
                                    <div
                                        style={{
                                            backgroundImage: `url(${postContent?.image_url}),linear-gradient(180deg, rgba(196, 196, 196, 0) 46.47%, #000000 100%)`,
                                        }}
                                        className="cards-img"
                                    >
                                        <p className="cards-title-1-img ps-4 pb-3 d-flex align-items-end h-100">
                                            {postContent?.title_bn}
                                        </p>
                                    </div>
                                </Link>
                            );
                        })}
                    </div>

                    <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-4 pt-4">
                        <p className="cards-title-2">সর্বশেষ সংবাদ</p>
                        <div className="row">
                            {latest_post?.slice(0, 6).map((postContent) => {
                                return (
                                    <div key={postContent.id} className="col-6 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-3 pt-3">
                                        <div className="cards">
                                            <Link to={`/${postContent?.slug_bn}`}>
                                                <div className="second-card-container">
                                                    <p className="cards-title-3 card-hd-font-size mb-2">
                                                        {postContent?.title_bn}
                                                    </p>
                                                    <p className="cards-content-text-time">
                                                        <MomentTo
                                                            date={
                                                                postContent?.published_at
                                                            }
                                                        />
                                                    </p>
                                                </div>
                                            </Link>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </div>
                <hr />
            </div>
        </div>
    );
};

export default ExclusiveAndLatest;
