import React from "react";
import {Link} from "react-router-dom";
import Preloader from "../../../../src/components/preloader/Preloader";

const PosCardSix = ({category}) => {
    if (!category) {
        return <Preloader />;
    }

    const {posts} = category;
    const slice = posts.slice(1, 4);

    function firstPost(post) {
        return (
            <div className="seven-card img position-relative" style={{backgroundImage: `url('${post.image_url}')`}}>
                <p className="cards-title-1-img d-flex align-items-end h-100 p-2 title">
                    <Link className="stretched-link text-decoration-none" to={`/posts/${post.slug}`}>
                        {post.title}
                    </Link>
                </p>
            </div>
        );
    }

    return (
        <div className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 mb-5 mb-md-0">
            <p className="cards-title-2">{category.name}</p>
            {posts && posts[0] && firstPost(posts[0])}

            {slice.map((post, index) => (
                <React.Fragment key={post.id}>
                    <p className="cards-title-3 pt-3">
                        <Link className="text-decoration-none" to={`/posts/${post.slug}`}>
                            {post.title}
                        </Link>
                    </p>
                    {index !== slice.length - 1 && <hr />}
                </React.Fragment>
            ))}
        </div>
    );
};

export default PosCardSix;
