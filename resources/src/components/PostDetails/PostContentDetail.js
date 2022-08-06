import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link, useLocation } from "react-router-dom";
import { fetchPostDetail } from "../../Features/menuPostsDetails/PostDetailSlice";
import { fetchPost } from "../../Features/posts/postSlice";
import MomentConverter from "../../MomentJs/MomentConverter";
import MomentTo from "../../MomentJs/MomentTo";
import Footer from "../Shared/Footer/Footer";
import Navbar from "../Shared/Navbar/Navbar";
import SocialIcon from "../SocialIcon/SocialIcon";
// import MomentDateTimePubluisher from "./moment/MomentDateTimePubluisher";

const PostContentDetail = () => {
    const [data, setData] = useState(18);
    let location = useLocation();
    const dispatch = useDispatch();
    // const [shouldRender, setShouldRender] = useState(true);
    const pathname = location.pathname;
    const path = pathname.slice(1);
    const { postsDetail } = useSelector((state) => state.postDetail);
    const { posts } = useSelector((state) => state.posts);
    console.log(posts);
    // console.log(isLoading);
    const { slug_en, category } = location?.state?.description;
    console.log(path);
    useEffect(() => {
        dispatch(fetchPostDetail(path));
    }, [slug_en,path]);
		console.log(location);
    // 	useEffect(() => {
    // 		// state.posts.isLoading = false;
    // 		dispatch(fetchPost(slug_bn));
    // }, [dispatch]);
    // if( !shouldRender ) return null;
    return (
        <div>
            <Navbar />

            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12">
                            <div>
                                <div class="loading-title1">
                                    <a class="d-block" href="">
                                        <p class="cards-title2-1 pt-xxl-2 pt-xl-2 pt-md-2 pt-3 pb-3">
                                            {postsDetail?.category?.name_bn}
                                        </p>
                                    </a>
                                </div>
                                <p class="cards-title2-2">
                                    বিক্ষোভ সমাবেশে নুরুল
                                </p>

                                <h1 class="cards-title1-1">
                                    {postsDetail?.title_bn}
                                </h1>
                                <p class="cards-content-text-time">
                                    {posts?.editor?.name}
                                </p>
                                <div class="d-flex flex-xxl-row flex-lg-row flex-md-row flex-sm-column flex-column justify-content-between mb-3">
                                    <p class="cards-content-text-time d-flex gap-2">
                                        {`প্রকাশ:`}
                                        <MomentConverter
                                            date={postsDetail?.published_at}
                                            formate={"LL, HH:mm"}
                                        />
                                    </p>
                                    <div>
                                        <SocialIcon
                                            data={data}
                                            setData={setData}
                                        />
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="col-12">
                                <div class="row ">
                                    <div class="col-12">
                                        <img src="" alt="" />
                                    </div>
                                    <div class="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12 m-auto">
                                        <div class="loading-page-img">
                                            <img
                                                class="w-100 h-100 img-fluid"
                                                src={postsDetail?.image_url}
                                                alt=""
                                            />
                                        </div>
                                        <figcaption class="d-block pt-2">
                                            ছাত্রদলের দুই নেতা–কর্মীকে
                                            শহীদুল্লাহ হলের ড্রেনে ফেলে পেটানো
                                            হয় | ছবি: প্রথম আলো
                                        </figcaption>
                                        <hr />
                                        <div>
                                            <p
                                                style={{
                                                    fontSize: data
                                                        ? `${data}px`
                                                        : "16px",
                                                }}
                                                class="cards-title-4"
                                            >
                                                {postsDetail?.content_bn}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <hr class="d-xxl-none d-xl-none d-md-none d-sm-block d-block" />
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-md-12 col-sm-8 col-8 m-auto">
                                    <div class="ad-container">
                                        <p class="d-flex justify-content-center align-items-center h-100 text-white">
                                            Ads
                                        </p>
                                    </div>
                                </div>
                                {posts?.slice(0, 1).map((description) => {
                                    return (
                                        <div class="col-12 row-2nd">
                                            <hr />
                                            <div class="cards">
                                                <Link
                                                    to={`/${description?.slug_bn}`}
                                                    state={{
                                                        description,
                                                    }} onClick={() => window.scrollTo(0, 0)}
                                                >
                                                    <div class="img">
                                                        <img
                                                            class="d-inline-block w-100 h-100 overflow-hidden img"
                                                            src={
                                                                description?.image_url
                                                            }
                                                            alt=""
                                                        />
                                                    </div>
                                                    <p class="cards-title-3 pt-2 pb-2">
                                                        {description?.title_bn}
                                                    </p>
                                                    <p class="cards-content-text-time">
                                                        <MomentTo
                                                            date={
                                                                description?.published_at
                                                            }
                                                        />
                                                    </p>
                                                </Link>
                                            </div>
                                            <hr />
                                        </div>
                                    );
                                })}

                                {posts?.slice(2, 6).map((description) => {
                                    return (
                                        <div class="col-12">
                                            <div class="cards">
                                                <Link
                                                    to={`/${description?.slug_bn}`}
                                                    state={{
                                                        description,
                                                    }} onClick={() => window.scrollTo(0, 0)}
                                                >
                                                    <p class="cards-title2-3 mb-2">
                                                        {description?.title_bn}
                                                    </p>
                                                    <div class="float-img ms-2 overflow-hidden">
                                                        <img
                                                            class="d-inline-block h-100 w-100 img-fluid"
                                                            src={
                                                                description.image_url
                                                            }
                                                            alt=""
                                                        />
                                                    </div>
                                                    <div class="">
                                                        <p class="cards-content-text pb-2">
                                                            {description?.content_bn.slice(
                                                                0,
                                                                100
                                                            )}
                                                        </p>
                                                        <p class="cards-content-text-time justify-content-between">
                                                            <MomentTo
                                                                date={
                                                                    description?.published_at
                                                                }
                                                            />
                                                        </p>
                                                    </div>
                                                </Link>
                                            </div>
                                            <hr />
                                        </div>
                                    );
                                })}
                                <div class="col-xxl-12 col-xl-12 col-md-12 col-sm-10 col-10 m-auto">
                                    <hr />
                                    <div class="sm-ads-container">
                                        <p class="d-flex justify-content-center align-items-center text-white h-100">
                                            Ads
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <hr />
                    <div class="row">
                        <div class="col-10 m-auto">
                            <div class="ad-container my-1">
                                <p class="d-flex justify-content-center align-items-center h-100 text-white">
                                    Ads
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
                <div class="container">
                    <div class="row">
                        {posts?.slice(0, 1).map((description) => {
                            return (
                                <p class="cards-title2-1 fw-normal">
                                   {`${description?.category?.name_bn}
                                      নিয়ে আরও পড়ুন`}
                                </p>
                            );
                        })}
                        {posts?.slice(7, 11).map((description) => {
                            return (
                                <div class="col-xxl-3 col-xl-3 col-md-3 col-sm-6 col-6">
                                    <div class="cards pb-3">
                                        <Link to={`/${description?.slug_bn}`}
																				state={{
																					description,
																			}} onClick={() => window.scrollTo(0, 0)}>
                                            <div class="third-container-card overflow-hidden">
                                                <img
                                                    class="img-fluid h-100"
                                                    src={description?.image_url}
                                                    alt=""
                                                />
                                            </div>
                                            <p class="cards-title-3 pt-3">
                                                {description?.title_bn}
                                            </p>
                                            <p class="pt-3 cards-content-text-time">
                                                <MomentTo
                                                    date={
                                                        description?.published_at
                                                    }
                                                />
                                            </p>
                                        </Link>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                    <hr />
                </div>
                {/* </> */}
            </div>

            <Footer />
        </div>
    );
};

export default PostContentDetail;
