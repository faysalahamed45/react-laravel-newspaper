import {Component} from "react";
import {connect} from "react-redux";
import HighlightedPost from "../components/posts/HighlightedPost";
import AdsPost from "../components/posts/AdsPost";
import {getPosts} from "../features/posts/PostSlice";
import Spinner from "../components/Spinner";

function Category({category, className}) {
    const posts = category.posts;

    return (
        <div className={className}>
            <div className="text-center">
                <div className="card-box-title">{category.name}</div>
            </div>
            {posts &&
                posts.map((item, index) => (
                    <div key={item.id} className={index !== 0 ? "mt-4" : ""}>
                        <div className="card-box-body text-start mt-2" dangerouslySetInnerHTML={{__html: item.content}} />
                    </div>
                ))}
        </div>
    );
}

class Home extends Component {
    state = {
        loading: true,
    };

    async componentDidMount() {
        this.setState({loading: true});
        await this.props.getPosts();
        this.setState({loading: false});
    }

    render() {
        return (
            <>
                <div className="row justify-content-between">
                    <div className="col-12">
                        <Spinner spinner={this.state.loading} />
                    </div>
                    <div className="col-12 d-md-none">
                        <div className="row">
                            <HighlightedPost posts={this.props.posts.premium_post} />
                        </div>
                    </div>
                    <div className="col-6 col-md-3 card-box">
                        {this.props.posts.category_post &&
                            this.props.posts.category_post.slice(0, 2).map(category => <Category key={category.id} category={category} className="mb-4" />)}
                    </div>
                    <div className="col-6 col-md-9">
                        <div className="row">
                            <div className="col-12 d-none d-md-block">
                                <div className="row">
                                    <HighlightedPost posts={this.props.posts.premium_post} />
                                </div>
                            </div>

                            {this.props.posts.category_post &&
                                this.props.posts.category_post.slice(2, this.props.posts.category_post.length).map(category => (
                                    <div key={category.id} className="col-12 col-md-4 card-box">
                                        <Category category={category} className="mb-4" />
                                    </div>
                                ))}

                            {/*<div className="col-4 card-box">
                                <AdsPost image={baseUrl + '/img/Screenshot 2022-04-06 at 1.56 1.png'}/>
                                <AdsPost image={baseUrl + '/img/Screenshot 2022-04-06 at 1.56 1.png'}/>
                            </div>*/}
                            <div className="col-12 d-none d-md-block">
                                <div className="advertisement d-flex flex-column justify-content-center align-items-center mt-4 text-center">
                                    <p>বিজ্ঞাপন দিতে যোগাযোগ করুন</p>
                                    <p className="fw-bold addNumber mb-0">০৬৫৫৯৩৪৮৮৫</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-12 d-md-none">
                        <div className="advertisement d-flex flex-column justify-content-center align-items-center mt-4 text-center">
                            <p className="mb-1 pt-3">বিজ্ঞাপন দিতে যোগাযোগ করুন</p>
                            <p className="fw-bold addNumber mb-0 pb-3">০৬৫৫৯৩৪৮৮৫</p>
                        </div>
                    </div>
                </div>
                <div className="header-img mb-5 mt-5">
                    <img className="img-fluid w-100 h-100" src={baseUrl + "/img/Screenshot 2022-04-06 at 1.53 1.png"} alt="" />
                </div>
            </>
        );
    }
}

const mapStateToProps = state => ({
    posts: state.posts.data,
});

export default connect(mapStateToProps, {getPosts})(Home);
