import React from "react";
import { Link } from "react-router-dom";

const SecondCard = ({ amerika }) => {
    return (
        <>
            {amerika?.slice(1, 2).map((postContent) => {
                return (
                    <div key={postContent.id} className="col-xxl-4 col-xl-4 col-md-4 col-sm-6 col-6 third-container-card-fborder third-container-card-sborder">
                        <div className="cards mb-3">
                            <Link to={`/${postContent?.slug_bn}`}>
                                <div className="third-container-card overflow-hidden">
                                    <img
                                        className="img-fluid h-100 w-100"
                                        src={postContent?.image_url}
                                        alt=""
                                    />
                                </div>
                                <p className="cards-title-3 pt-3">
																{postContent?.title_bn.slice(60)}
                                </p>
                            </Link>
                        </div>
                    </div>
                );
            })}
        </>
    );
};

export default SecondCard;
