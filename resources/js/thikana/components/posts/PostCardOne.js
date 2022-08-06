import React from "react";
import {Link} from "react-router-dom";
import Moment from "react-moment";
import Preloader from "../../../../src/components/preloader/Preloader";

const PostCardOne = ({post}) => {
    if (!post) {
        return <Preloader />;
    }

    return (
        <Link to={`/posts/${post.slug}`} className="text-decoration-none">
            <div className="row">
                <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12 order-xxl-0 order-xl-0 order-md-0 order-sm-1 order-1">
                    <div className="cards">
                        <p className="cards-title-1 pb-2 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-3 pt-3">{post.title}</p>
                        <p className="cards-content-text pb-2">
                            {post.content.htmlToText().slice(0, 150)}
                            <span>...</span>
                        </p>
                        <p className="cards-content-text-time">
                            <Moment locale="bn" to={post.published_at} />
                        </p>
                    </div>
                </div>
                <div className="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-12 ps-0 pe-xxl-3 pe-xl-3 pe-md-3 pe-sm-0 pe-0 order-xxl-1 order-xl-1 order-md-1 order-sm-0 order-0 overflow-hidden">
                    <div className="thikana-1st-content-img overflow-hidden">
                        <img className="w-100 h-100 img-fluid" src={post.image_url} alt="" />
                    </div>
                    <figcaption className="pt-2 ps-xxl-0 ps-xl-0 ps-md-0 ps-sm-3 ps-3">{post.title} | ছবি: প্রথম আলো</figcaption>
                </div>
            </div>
        </Link>
    );
};

export default PostCardOne;
