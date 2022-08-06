import React, { memo, useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link, useLocation } from "react-router-dom";
import { fetchPost } from "../../Features/posts/postSlice";
import Footer from "../Shared/Footer/Footer";
import Navbar from "../Shared/Navbar/Navbar";
import MomentTo from "../../MomentJs/MomentTo";
import MomentConverter from "../../MomentJs/MomentConverter";
import Preloader from "../preloader/Preloader";

const FirstPostDetail = () => {
    const [showMore, setShowMore] = useState(4);
    let location = useLocation();
    const path = location.pathname;
    const pathSlice = path.slice(1);

    const { posts, isLoading } = useSelector((state) => state.posts);
    // console.log(posts[0]);
    // console.log(pathSlice);
    const dispatch = useDispatch();
    useEffect(() => {
        // state.posts.isLoading = false;
        dispatch(fetchPost(path));
        setShowMore(4);
    }, [dispatch, path]);

    const showMoreData = () => {
        setShowMore(showMore + 5);
    };

    return (
        <>
            {isLoading ? (
                <>
                    <Navbar />
                    <main>
                        <div className="container">
                            <div className="row">
                                <div className="col-10 m-auto">
                                    <p className="cards-title-big pt-xxl-2 pt-xl-2 pt-md-2 pt-3 pb-2">
                                        {/* {category?.name_bn} */}
                                        {posts[0]?.category?.name_en}
                                    </p>
                                    <hr />
                                </div>
                            </div>
                        </div>
                        <div className="container">
                            <div className="row justify-content-center">
                                <div className="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12">
                                    <div className="row justify-content-end">
                                        {posts
                                            ?.slice(0, showMore)
                                            .map((description) => {
                                                return (
                                                    // <Link to="/content/description">
                                                    <div
                                                        key={description.id}
                                                        className="col-xxl-10 col-xl-10 col-md-10 col-sm-12 col-12 firstPostdescription"
                                                    >
                                                        <Link
                                                            to={`/${description?.slug_bn}`}
                                                            state={{
                                                                description,
                                                            }} onClick={() => window.scrollTo(0, 0)}
                                                        >
                                                            <div className="row">
                                                                <div className="col-7">
                                                                    <div className="cards">
                                                                        <p className="cards-title2-1 pb-2">
                                                                            {
                                                                                description.title_bn
                                                                            }
                                                                        </p>
                                                                        <p className="cards-content-text pb-4">
                                                                            {description.content_bn.slice(
                                                                                0,
                                                                                220
                                                                            )}
                                                                        </p>
                                                                        <time
                                                                            cards-content-text-time
                                                                        >
                                                                            <MomentTo
                                                                                date={
                                                                                    description?.published_at
                                                                                }
                                                                            />
                                                                        </time>
                                                                    </div>
                                                                </div>
                                                                <div className="col-5">
                                                                    <div className="prime-news-img">
                                                                        <img
                                                                            className="img-fluid w-100"
                                                                            src={
                                                                                description.image_url
                                                                            }
                                                                            alt={
                                                                                "imgage not show"
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </Link>
                                                        <hr />
                                                    </div>
                                                );
                                            })}
                                        <div className="col-xxl-10 col-xl-10 col-md-10 col-sm-12 col-12 pb-2 d-flex justify-content-center">
                                            {/* {posts[0]?.category?.name_en ==
                                                pathSlice && ( */}
                                                <button
                                                    onClick={showMoreData}
                                                    className="btn btn-primary"
                                                >
                                                    আরও
                                                </button>
                                            {/* )} */}
                                        </div>
                                    </div>
                                </div>
                                <div className="col-3 d-xxl-block d-xl-block d-md-block d-sm-none d-none">
                                    <div className="ad-container">
                                        <p className="d-flex justify-content-center align-items-center h-100 text-white">
                                            Ads
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="container">
                            {/* <!-- <hr> --> */}
                            <div className="row">
                                <div className="col-10 m-auto">
                                    <div className="ad-container my-1">
                                        <p className="d-flex justify-content-center align-items-center h-100 text-white">
                                            Ads
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </main>
                    <Footer />
                </>
            ) : (
                <Preloader />
            )}
        </>
    );
};

export default memo(FirstPostDetail);
