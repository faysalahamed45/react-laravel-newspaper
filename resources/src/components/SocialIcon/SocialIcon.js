import React, { useState } from "react";
import facebook from "../../../../public/assets/svgIcon/facebook.svg";
import twitter from "../../../../public/assets/svgIcon/twitter.svg";
import share from "../../../../public/assets/svgIcon/share.svg";
import plus from "../../../../public/assets/svgIcon/plus.svg";
import minus from "../../../../public/assets/svgIcon/minus.svg";
import printer from "../../../../public/assets/svgIcon/printer.svg";
import WebShare from "./WebShare";

const SocialIcon = ({ setData, data }) => {
	const [show, setShow] = useState(false);
	const toggle = () => {
		setShow(!show);

};
    return (
        <div>
            <div className="socialIcon d-flex">
                <a href="#">
										<img src={facebook}/>
                </a>
                <a href="#">
								<img src={twitter}/>
                </a>
                <a onClick={toggle} className="webShare">
								<img src={share}/>
								<WebShare toggle={toggle} show={show}/>
                </a>
                <a onClick={() => setData(data + 5)}>
								<img src={plus}/>
                </a>
								<a onClick={() => setData(data - 5)}>
								<img src={minus}/>
                </a>
                <a onClick="window.print()">
                    <img src={printer}/>
                </a>

                {/* <button onClick={() => setData(data + 5)}>plus</button>
                <button onClick={() => setData(data - 5)}>minus</button> */}
            </div>
        </div>
    );
};

export default SocialIcon;
