import React, {useEffect} from "react";
import {Link} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {fetchHomePost} from "../features/homePosts/homePostslice";
import PostCardOne from "../components/posts/PostCardOne";
import PostCardTwo from "../components/posts/PostCardTwo";
import PostCardThree from "../components/posts/PostCardThree";
import PosCardFour from "../components/posts/PostCardFour";
import PosCardFive from "../components/posts/PostCardFive";
import PosCardSix from "../components/posts/PostCardSix";
import NumberedPostCard from "../components/posts/NumberedPostCard";
import Video from "../../../src/components/Home/LatestAndVideo/Video/Video";
import OwlCarousel from "react-owl-carousel";
import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel/dist/assets/owl.theme.default.css";

const Home = () => {
    const dispatch = useDispatch();
    const {
        feature_post,
        feature_post_2,
        exclusive,
        latest_post,
        top_read,
        category_section_1,
        category_section_2,
        category_section_3,
        category_section_5,
        category_section_6,
        category_section_7,
        category_section_8,
        category_section_9,
    } = useSelector(state => state.homePost);

    useEffect(() => {
        dispatch(fetchHomePost());
    }, []);

    return (
        <>
            <div className="container">
                <div className="row">
                    <div className="col-xxl-12 col-xl-12 col-md-12 col-sm-12 col-12 mt-md-3 lead-news">
                        <div className="row">
                            <div className="col-md-8">
                                <PostCardOne post={feature_post?.[0]} />
                            </div>

                            <div className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 thikana-1st-content order-xxl-3 order-xl-3 order-md-3 order-sm-3 order-3">
                                <PostCardTwo post={feature_post?.[1]} />
                            </div>
                        </div>
                        <hr className="d-none d-md-block mt-md-3" />
                        <div className="row">
                            {feature_post?.slice(2, 4).map(post => (
                                <div key={post.id} className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 mb-5 mt-md-3">
                                    <PostCardTwo post={post} />
                                </div>
                            ))}
                            <div className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 mb-5 mt-md-3">
                                <div className="fifth-card-sm-card img4">
                                    <p className="d-flex align-items-center justify-content-center h-100 text-white">Ads</p>
                                </div>
                            </div>
                        </div>
                        <hr className="d-none d-md-block mt-md-3" />
                        <div className="row">
                            <div className="col-10 m-auto">
                                <div className="header-advertising-card my-3">
                                    <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                                </div>
                            </div>
                        </div>
                        <hr className="d-none d-md-block mt-md-3" />
                        {/* <div className="row PostCardThree-row">
                            {feature_post_2?.slice(0, 6).map(post => (
                                <div key={post.id} className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 mb-2 mb-md-4">
                                    <PostCardThree post={post} />
                                </div>
                            ))}
                        </div> */}
                    </div>

                    {/* <div className="col-xxl-3 col-xl-3 col-md-3 col-sm-12 col-12">
                        <div className="row">
                            <div className="col-xxl-12 col-xl-12 col-md-12 col-sm-10 col-10 m-auto">
                                <div className="ad-container">
                                    <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                                </div>
                            </div>

                            {feature_post_2?.[6] && (
                                <div className="col-12">
                                    <PosCardFive post={feature_post_2?.[6]} />
                                    <hr />
                                </div>
                            )}

                            {feature_post_2?.[7] && (
                                <div className="col-12">
                                    <PostCardThree post={feature_post_2?.[7]} />
                                    <hr />
                                </div>
                            )}
                            <div className="col-xxl-12 col-xl-12 col-md-12 col-sm-10 col-10 m-auto">
                                <div className="sm-ads-container">
                                    <p className="d-flex justify-content-center align-items-center text-white h-100">Ads</p>
                                </div>
                            </div>
                        </div>
                    </div> */}
                </div>
            </div>

            <div className="container">
                <div className="row">
                    <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12">
                        <p className="cards-title-2">এক্সক্লুসিভ</p>
                        <Exclusive post={exclusive?.[0]} />
                    </div>

                    <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-4 pt-4">
                        <p className="cards-title-2">সর্বশেষ সংবাদ</p>
                        <div className="row lasted-news">
                            {latest_post?.slice(0, 6).map(post => (
                                <div key={post.id} className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12">
                                    <PosCardFour post={post} />
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
                <hr />
            </div>

            {category_section_1 && (
                <div className="container">
                    <p className="cards-title-2">{category_section_1.name}</p>
                    <div className="row third-container">
                        {category_section_1.posts
                            ?.slice(0, 4)
                            .insert([2, 5], [333, 999])
                            .map((post, index) => (
                                <America key={index} post={post} />
                            ))}
                    </div>
                    <hr />
                </div>
            )}

            <div className="container pt-2">
                <div className="row">
                    <div className="col-xxl-3 col-xl-3 col-md-3 col-sm-12 col-12">
                        <nav>
                            <div className="nav nav-tabs" id="nav-tab" role="tablist">
                                <button
                                    className="nav-link active"
                                    id="nav-0001-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-0001"
                                    type="button"
                                    role="tab"
                                    aria-controls="nav-0001"
                                    aria-selected="true">
                                    সর্বাধিক পঠিত
                                </button>
                                {(function (category_section) {
                                    if (!category_section) {
                                        return null;
                                    }

                                    return (
                                        <button
                                            className="nav-link"
                                            id="nav-0002-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#nav-0002"
                                            type="button"
                                            role="tab"
                                            aria-controls="nav-0002"
                                            aria-selected="false">
                                            {category_section.name}
                                        </button>
                                    );
                                })(category_section_5)}
                            </div>
                        </nav>
                        <div className="tab-content" id="nav-tabContent">
                            <div className="tab-pane fade show active" id="nav-0001" role="tabpanel" aria-labelledby="nav-0001-tab">
                                <div className="most-read">
                                    {top_read?.slice(0, 3).map((post, index) => (
                                        <NumberedPostCard key={post.id} post={post} number={index + 1} />
                                    ))}
                                </div>
                            </div>
                            {(function (category_section) {
                                if (!category_section) {
                                    return null;
                                }

                                return (
                                    <div className="tab-pane fade" id="nav-0002" role="tabpanel" aria-labelledby="nav-0002-tab">
                                        <div className="most-read">
                                            {category_section.posts?.slice(0, 3).map((post, index) => (
                                                <NumberedPostCard key={post.id} post={post} number={index + 1} />
                                            ))}
                                        </div>
                                    </div>
                                );
                            })(category_section_5)}
                        </div>

                        <div className="fourth-card-ad d-xxl-block d-xl-block d-md-block d-sm-none d-none">
                            <hr />
                            <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                        </div>
                    </div>
                    <div className="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12">
                        <hr className="d-xxl-none d-xl-none d-md-none d-sm-block d-block mb-0" />
                        <p className="cards-title-2 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-3 pt-3">ভিডিও</p>
                        <div className="row">
                            <Video />

                            <div className="col-12">
                                <div className="row">
                                    {feature_post_2 &&
                                        [...feature_post_2]
                                            .sort(() => 0.5 - Math.random())
                                            .slice(0, 2)
                                            .map(post => (
                                                <div key={post.id} className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12">
                                                    <PosCardFive post={post} />
                                                </div>
                                            ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr className="mt-5" />
            </div>

            {(function (category_section) {
                if (!category_section) {
                    return null;
                }

                return (
                    <div className="container pt-2">
                        <div className="row">
                            <p className="cards-title-2">{category_section.name}</p>
                            {category_section.posts[0] && (
                                <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12">
                                    <Link to={`/posts/${category_section.posts[0].slug}`} className="text-decoration-none">
                                        <div className="fifth-card-container" style={{backgroundImage: `url('${category_section.posts[0].image_url}')`}}>
                                            <p className="cards-title-1-img d-flex align-items-end ps-4 pb-3 h-100">{category_section.posts[0].title}</p>
                                        </div>
                                    </Link>
                                </div>
                            )}
                            <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-4 pt-4">
                                <div className="row">
                                    {category_section.posts.slice(1, 4).map(post => (
                                        <div key={post.id} className="col-6 mb-4">
                                            <Link to={`/posts/${post.slug}`} className="text-decoration-none">
                                                <div className="fifth-card-sm-card img1" style={{backgroundImage: `url('${post.image_url}')`}}>
                                                    <p className="cards-title-4-img d-flex align-items-end h-100 p-2">{post.title}</p>
                                                </div>
                                            </Link>
                                        </div>
                                    ))}
                                    <div className="col-6">
                                        <div className="fifth-card-sm-card img4">
                                            <p className="d-flex align-items-center justify-content-center h-100 text-white">Ads</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                );
            })(category_section_2)}

            <div className="container">
                <div className="row">
                    <div className="col-10 ad-container my-1">
                        <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                    </div>
                </div>
                <hr />
            </div>

            {(function (category_section) {
                if (!category_section) {
                    return null;
                }

                return (
                    <div className="container">
                        <div className="row">
                            <p className="cards-title-2">{category_section.name}</p>
                            {category_section.posts[0] && (
                                <div className="col-xxl-5 col-xl-5 col-md-5 col-sm-12 col-12">
                                    <Link to={`/posts/${category_section.posts[0].slug}`} className="text-decoration-none">
                                        <div className="sixth-card-container-1st" style={{backgroundImage: `url('${category_section.posts[0].image_url}')`}}>
                                            <p className="cards-title-1-img d-flex align-items-end h-100 ps-4 pb-3">{category_section.posts[0].title}</p>
                                        </div>
                                    </Link>
                                </div>
                            )}
                            <div className="col-xxl-7 col-xl-7 col-md-7 col-sm-12 col-12 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-4 pt-4">
                                {category_section.posts.slice(1, 3).map(post => (
                                    <Link key={post.id} to={`/posts/${post.slug}`} className="text-decoration-none">
                                        <div className="row mb-4">
                                            <div className="col-6">
                                                <div className="">
                                                    <p className="cards-title-3">{post.title}</p>
                                                    <p className="cards-content-text mt-3">{post.content.htmlToText().slice(0, 220)}</p>
                                                </div>
                                            </div>
                                            <div className="col-6">
                                                <div className={"sixth-card-container-2nd img"} style={{backgroundImage: `url('${post.image_url}')`}} />
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        </div>
                        <hr />
                    </div>
                );
            })(category_section_3)}

            <div className="container">
                <div className="row">
                    <PosCardSix category={category_section_6} />
                    <PosCardSix category={category_section_7} />
                    <PosCardSix category={category_section_8} />
                </div>
                <hr />
            </div>

            {category_section_9 && (
                <div className="container">
                    <p className="cards-title-2">{category_section_9.name}</p>
                    <OwlCarousel items={4} className="owl-theme" loop margin={10}>
                        {category_section_9.posts.map(post => (
                            <div key={post.id}>
                                <img className="img" src={post.image_url} />
                            </div>
                        ))}
                    </OwlCarousel>
                    <hr />
                </div>
            )}
        </>
    );
};

function Exclusive({post}) {
    if (!post) {
        return <></>;
    }

    return (
        <Link className="text-decoration-none" to={`/${post.slug}`}>
            <div
                style={{
                    backgroundImage: `url(${post.image_url}),linear-gradient(180deg, rgba(196, 196, 196, 0) 46.47%, #000000 100%)`,
                }}
                className="cards-img">
                <p className="cards-title-1-img ps-4 pb-3 d-flex align-items-end h-100">{post.title}</p>
            </div>
        </Link>
    );
}

function America({post}) {
    if (isNaN(post)) {
        return (
            <div className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 third-container-card-fborder">
                <PosCardFive post={post} />
            </div>
        );
    }

    return (
        <div className="col-xxl-4 col-xl-4 col-md-4 col-sm-10 col-10 third-container-ad m-xxl-0 m-xl-0 m-md-0 m-sm-auto m-auto">
            <div className="third-container-card-ad my-xxl-0 my-xl-0 my-md-0 my-sm-3 my-3">
                <p className="d-flex justify-content-center align-items-center text-white h-100">Ads</p>
            </div>
        </div>
    );
}

export default Home;
