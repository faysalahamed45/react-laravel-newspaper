import React from "react";
import {Link} from "react-router-dom";
import Preloader from "../../../../src/components/preloader/Preloader";

const PosCardFive = ({post}) => {
    if (!post) {
        return <Preloader />;
    }

    return (
        <div className="cards pb-3">
            <Link to={`/posts/${post.slug}`}>
                <div className="third-container-card overflow-hidden">
                    <img className="img-fluid h-100 w-100" src={post.image_url} alt={post.title} />
                </div>
                <p className="cards-title-3 pt-3">{post.title}</p>
            </Link>
        </div>
    );
};

export default PosCardFive;
