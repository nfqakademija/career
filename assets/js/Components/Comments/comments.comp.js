import React from "react";
import { setComment } from "../../Actions/action";
import { connect } from "react-redux";
// import picturePress from '../../../pics/press.svg';

class Comments extends React.Component {
  constructor() {
    super();

    this.state = {
      changeComment: false,
      inputValue: "No comments"
    };
  }

  componentDidMount() {
    for (let i = 0; i < this.props.choiceList.length; i++) {
      if (this.props.choiceList[i].criteriaId === this.props.criteriaId) {
        this.setState({ inputValue: this.props.choiceList[i].comment });
      }
    }
  }

  handle = () => {
    this.setState({ changeComment: !this.state.changeComment });
    this.props.onSetComment(this.props.criteriaId, this.state.inputValue);
  };

  render() {
    return (
      <div>
        {this.state.changeComment ? (
          <React.Fragment>
            <input
              type="text"
              placeholder={this.state.inputValue}
              onChange={value =>
                this.setState({ inputValue: value.target.value })
              }
            />
            <button onClick={this.handle}>Save</button>
          </React.Fragment>
        ) : (
          <React.Fragment>
            <div className="comment-Box">
              <span className="comment">{this.state.inputValue}</span>
              <button
                className="commentButton"
                onClick={() =>
                  this.setState({ changeComment: !this.state.changeComment })
                }
              >
                Change
              </button>
            </div>
          </React.Fragment>
        )}
      </div>
    );
  }
}

const mapStateToProps = state => ({
  choiceList: state.user.choiceList
});

const mapDispatchToProps = dispatch => ({
  onSetComment: (criteriaId, comment) =>
    dispatch(setComment(criteriaId, comment))
});

export default connect(mapStateToProps, mapDispatchToProps)(Comments);
