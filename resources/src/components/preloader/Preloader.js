import React, { memo } from "react";

const Preloader = () => {
    return (
        <div id="preloader">
            {/* <!-- spinner --> */}
            {/* <div class="spinner">
                <div></div>
                <div></div>
            </div> */}

            {/* <!-- bouncing balls --> */}
            <div className="bouncer">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>

            {/* <!-- flipping squares --> */}
            {/* <div class="square">
                <div></div>
                <div></div>
            </div> */}
        </div>
    );
};

export default memo(Preloader);
