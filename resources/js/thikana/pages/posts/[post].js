import {useDispatch, useSelector} from "react-redux";
import React, {useEffect} from "react";
import {Link, useParams} from "react-router-dom";
import Moment from "react-moment";
import Preloader from "../../../../src/components/preloader/Preloader";
import {fetchPostDetails} from "../../features/posts/PostDetailsSlice";
import {fetchPost} from "../../features/posts/postSlice";

const Post = () => {
    const params = useParams();
    const dispatch = useDispatch();
    const {data: post} = useSelector(state => state.postDetails);
    const {posts} = useSelector(state => state.posts);

    useEffect(() => {
        dispatch(fetchPostDetails(params.post));
    }, [params.post]);

    useEffect(() => {
        if (post.category?.slug) {
            dispatch(fetchPost({category: post.category.slug}));
        }
    }, [post]);

    if (!post.id) {
        return <Preloader />;
    }

    return (
        <>
            <div className="container">
                <div className="row">
                    <div className="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12">
                        <div>
                            <div className="loading-title1">
                                <Link className="d-block" to={`/categories/${post.category.slug}`}>
                                    <p className="cards-title2-1 pt-xxl-2 pt-xl-2 pt-md-2 pt-3 pb-3">{post.category.name}</p>
                                </Link>
                            </div>
                            {/*<p className="cards-title2-2">বিক্ষোভ সমাবেশে নুরুল</p>*/}

                            <h1 className="cards-title1-1">{post.title}</h1>
                            <p className="cards-content-text-time">{post.editor.name}</p>
                            <div className="d-flex flex-xxl-row flex-lg-row flex-md-row flex-sm-column flex-column justify-content-between mb-3">
                                <p className="cards-content-text-time">
                                    প্রকাশ: <Moment locale="bn" to={post.published_at} format="DD MMM YYYY, HH: SS" />
                                </p>
                                <div className="brand-icon1">
                                    <a href="#">
                                        <i className="fa-brands fa-facebook"> </i>
                                    </a>
                                    <a href="#">
                                        <i className="fa-brands fa-youtube ps-3 cl-red"></i>
                                    </a>
                                    <a href="#">
                                        <i className="fa-brands fa-twitter ps-3"></i>
                                    </a>
                                    <a href="#">
                                        <i className="fa-brands fa-instagram ps-3 cl-red"></i>
                                    </a>
                                    <a onClick={window.print} href="#">
                                        <i className="fa-solid fa-print ps-3 text-secondary d-print-none"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div className="col-12">
                            <div className="row ">
                                <div className="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12 m-auto">
                                    <div className="loading-page-img">
                                        <img className="w-100 h-100 img-fluid" src={post.image_url} alt={post.title} />
                                    </div>
                                    <figcaption className="d-block pt-2">{post.title} | ছবি: ঠিকানা</figcaption>
                                    <hr />
                                    <div>
                                        <p className="cards-title-4" dangerouslySetInnerHTML={{__html: post.content}} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="col-xxl-3 col-xl-3 col-md-3 col-sm-12 col-12">
                        <hr className="d-xxl-none d-xl-none d-md-none d-sm-block d-block" />
                        <div className="row">
                            <div className="col-xxl-12 col-xl-12 col-md-12 col-sm-8 col-8 m-auto">
                                <div className="ad-container">
                                    <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                                </div>
                            </div>
                            {posts
                                ?.filter(i => i.id !== post.id)
                                .slice(0, 6)
                                .map(post => (
                                    <div key={post.id} className="col-12 row-2nd">
                                        <hr />
                                        <div className="cards">
                                            <Link to={`/posts/${post.slug}`}>
                                                <div className="img">
                                                    <img className="d-inline-block w-100 h-100 overflow-hidden img" src={post.image_url} alt={post.title} />
                                                </div>
                                                <p className="cards-title-3 pt-2 pb-2">{post.title}</p>
                                                <p className="cards-content-text-time">
                                                    <Moment locale="bn" to={post.published_at} />
                                                </p>
                                            </Link>
                                        </div>
                                        <hr />
                                    </div>
                                ))}
                            <div className="col-xxl-12 col-xl-12 col-md-12 col-sm-10 col-10 m-auto">
                                <hr />
                                <div className="sm-ads-container">
                                    <p className="d-flex justify-content-center align-items-center text-white h-100">Ads</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr className="mt-5" />
            </div>
        </>
    );
};

export default Post;
