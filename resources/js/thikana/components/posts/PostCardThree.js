import React from "react";
import {Link} from "react-router-dom";
import Moment from "react-moment";
import Preloader from "../../../../src/components/preloader/Preloader";

const PosCardThree = ({post}) => {
    if (!post) {
        return <Preloader />;
    }

    return (
        <div className="cards">
            <Link to={`/posts/${post.slug}`}>
                <div className="float-img ms-2 overflow-hidden">
                    <img className="d-inline-block h-100 w-100 img-fluid" src={post.image_url} alt={post.title} />
                </div>
                <div className="">
                    <p className="cards-title-3 pb-2">{post.title}</p>
                    <p className="cards-content-text-time justify-content-between pb-2">
                        <Moment locale="bn" to={post.published_at} />
                    </p>
                </div>
            </Link>
        </div>
    );
};

export default PosCardThree;
