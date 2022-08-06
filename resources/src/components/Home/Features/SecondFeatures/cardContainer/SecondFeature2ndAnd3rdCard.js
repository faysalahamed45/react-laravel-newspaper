import React from 'react';
import { Link } from "react-router-dom";
import MomentTo from '../../../../../MomentJs/MomentTo';

const SecondFeature2ndAnd3rdCard = ({secondFeatures}) => {
	return (
		<>
			{secondFeatures?.slice(0, 1).map((propsContent) => {
                    return (
                        <div key={propsContent.id} className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12">
                            <div className="cards">
														<Link to={`/${propsContent?.slug_bn}`}>
                                    <div className="float-img ms-2 overflow-hidden">
                                        <img
                                            className="d-inline-block h-100 w-100 img-fluid"
                                            src={propsContent?.image_url}
                                            alt=""
                                        />
                                    </div>
                                    <div className="">
                                        <p className="cards-title-3 pb-2">
                                            {propsContent?.title_bn.slice(
                                                0,
                                                120
                                            )}
                                        </p>
                                        <p className="cards-content-text-time justify-content-between">
                                            <MomentTo
                                                date={
                                                    propsContent?.published_at
                                                }
                                            />
                                        </p>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    );
                })}
		</>
	);
};

export default SecondFeature2ndAnd3rdCard;