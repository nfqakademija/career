import React from "react";
import { setComment } from "../../Actions/action";
import { connect } from 'react-redux';

class Comments extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      changeComment: false,
      inputValue: props.comment
    };
  }

  handle = () => {
    this.setState({ changeComment: !this.state.changeComment });
    this.props.onSetComment(this.props.criteriaId, this.state.inputValue)
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
            <i className="fas fa-plus" onClick={this.handle} />
          </React.Fragment>
        ) : (
          <React.Fragment>
            {this.state.inputValue}
            <i
              className="fas fa-plus"
              onClick={() =>
                this.setState({ changeComment: !this.state.changeComment })
              }
            />
          </React.Fragment>
        )}
      </div>
    );
  }
}

const mapDispatchToProps = dispatch => ({
  onSetComment: (criteriaId, comment) => dispatch(setComment(criteriaId, comment))
})

export default connect(null, mapDispatchToProps)(Comments);
