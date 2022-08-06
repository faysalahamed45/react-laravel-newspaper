import React, {memo, useEffect, useState} from "react";
import {useDispatch, useSelector} from "react-redux";
import {Link, useParams} from "react-router-dom";
import Moment from "react-moment";
import {fetchPost} from "../../features/posts/postSlice";
import Preloader from "../../../../src/components/preloader/Preloader";

const Category = () => {
    const params = useParams();
    const dispatch = useDispatch();

    const {category, posts, pagination, isLoading} = useSelector(state => state.posts);
    useEffect(() => {
        dispatch(fetchPost({category: params.category, page: 1}));
    }, [dispatch, params.category]);

    const showMoreData = () => {
        if (pagination.next_page_url) {
            dispatch(fetchPost({category: params.category, page: pagination.current_page + 1}));
        }
    };

    if (isLoading) {
        return <Preloader />;
    }

    return (
        <main>
            <div className="container">
                <div className="row">
                    <div className="col-10 m-auto">
                        <p className="cards-title-big pt-xxl-2 pt-xl-2 pt-md-2 pt-3 pb-2">{category?.name}</p>
                        <hr />
                    </div>
                </div>
            </div>
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12">
                        <div className="row justify-content-end">
                            {posts?.map(post => (
                                // <Link to="/content/post">
                                <div key={post.id} className="col-xxl-10 col-xl-10 col-md-10 col-sm-12 col-12 firstPostpost">
                                    <Link
                                        to={`/posts/${post.slug}`}
                                        state={{
                                            post,
                                        }}
                                        onClick={() => window.scrollTo(0, 0)}>
                                        <div className="row">
                                            <div className="col-7">
                                                <div className="cards">
                                                    <p className="cards-title2-1 pb-2">{post.title}</p>
                                                    <p className="cards-content-text pb-4">{post.content.htmlToText().slice(0, 220)}</p>
                                                    <time cards-content-text-time={post.published_at}>
                                                        <Moment locale="bn" to={post.published_at} />
                                                    </time>
                                                </div>
                                            </div>
                                            <div className="col-5">
                                                <div className="prime-news-img">
                                                    <img className="img-fluid w-100" src={post.image_url} alt="image not show" />
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                    <hr />
                                </div>
                            ))}
                            {pagination?.next_page_url && (
                                <div className="col-xxl-10 col-xl-10 col-md-10 col-sm-12 col-12 pb-2 d-flex justify-content-center">
                                    <button onClick={showMoreData} className="btn btn-primary">
                                        আরও
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>
                    <div className="col-3 d-xxl-block d-xl-block d-md-block d-sm-none d-none">
                        <div className="ad-container">
                            <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                        </div>
                    </div>
                </div>
            </div>
            <div className="container">
                {/* <!-- <hr> --> */}
                <div className="row">
                    <div className="col-10 m-auto">
                        <div className="ad-container my-1">
                            <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                        </div>
                    </div>
                </div>
                <hr />
            </div>
        </main>
    );
};

export default memo(Category);
