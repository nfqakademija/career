import React from "react";
import { connect } from "react-redux";
import { setAnswers } from "../../Actions/action";

class ChoiceList extends React.Component {
  constructor() {
    super();

    this.state = {
      choiceId: null
    };
  }

  setAnswer = id => {
    let obj = {
      choiceId: id,
      criteriaId: this.props.criteriaId
    };

    let { answers } = this.props;

    let found = 0;

    if (answers.length > 0) {
      for (let i = 0; i < answers.length; i++) {
        if (
          answers[i].choiceId === id &&
          answers[i].criteriaId === this.props.criteriaId
        ) {
          found = 1;
        }
      }
    }

    if (found === 0) {
      this.props.onSetAnswers(obj);
    }
  };

  render() {
    const { choices } = this.props;
    return (
      <select>
        {choices.map(choice => (
          <option
            onClick={() => this.setAnswer(choice.id)}
            key={choice.id}
            value={choice.title}
          >
            {choice.title}
          </option>
        ))}
      </select>
    );
  }
}

const mapStateToProps = state => ({
  answers: state.trackUserChanges.choiceAnswers
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: answer => dispatch(setAnswers(answer))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceList);
