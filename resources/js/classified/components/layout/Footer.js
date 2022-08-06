import {Link} from "react-router-dom";

export default function Footer() {
    return (
        <footer>
            <div className="footer">
                <div className="containers ps-md-5">
                    <h3 className="text-center text-md-start">গুরুত্বপূর্ণ লিংক</h3>
                    <div className="d-flex gap-3 gap-md-5 align-items-center justify-content-center justify-content-md-start text-decoration-none mt-4">
                        <Link to="/categories/অফিস - স্পেস ভাড়া">অফিস / স্পেস ভাড়া</Link>
                        <Link to="/categories/রুম ভাড়া">রুম ভাড়া</Link>
                        <Link to="/categories/রুমমেট">রুমমেট</Link>
                        <Link to="/categories/গ্রীন - ব্ল্যাক কার লিভারী ভাড়া">গ্রীন / ব্ল্যাক কার লিভারী ভাড়া</Link>
                    </div>
                    <div className="d-flex gap-3 gap-md-5 align-items-center justify-content-center justify-content-md-start mt-2">
                        <Link to="/categories/ক্রয় - বিক্রয় - লীজ">ক্রয় / বিক্রয় / লীজ</Link>
                        <Link to="/categories/অবশ্যক">অবশ্যক</Link>
                        <Link to="/categories/বিবিধ">বিবিধ</Link>
                    </div>
                </div>
            </div>
            <div className="containers-fluid copyright text-center fw-bolder mt-5">Copyright @Thikana Classified 2022</div>
        </footer>
    );
}
