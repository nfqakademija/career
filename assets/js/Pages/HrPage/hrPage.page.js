import React from "react";
import Axios from "axios";
import "./hrPage.style.scss";
import CheckBox from "../../Components/checkbox/checkbox.comp";

class HrPage extends React.Component {
  constructor() {
    super();

    this.state = {
      profiles: [],
      positions: [],
      position: null,
      competenceList: [],
      criteriaList: [],
      show: []
    };
  }

  componentDidMount() {
    Axios.get("/api/criteria/list")
      .then(res => {
        this.setState({ profiles: res.data.list });
      })
      .catch(err => console.log(err));

    Axios.get("/api/profession/list")
      .then(res => {
        this.setState({ positions: res.data.list });
      })
      .catch(err => console.log(err));
  }

  add = (competenceId, criteriaId) => {
    var joined = this.state.competenceList.concat(competenceId);
    this.state.competenceList.includes(competenceId)
      ? null
      : this.setState({ competenceList: joined });
    joined = this.state.criteriaList.concat(criteriaId);
    this.state.criteriaList.includes(criteriaId)
      ? null
      : this.setState({ criteriaList: joined });
  };

  remove = (competenceId, criteriaId, criteriaList) => {
    let min = criteriaList[0].id;
    let max;
    let count = 0;
    criteriaList.forEach(element => (max = element.id));
    this.state.criteriaList.forEach(element => {
      if (element >= min && element <= max) {
        count++;
      }
    });

    if (count === 1) {
      let copy = [...this.state.competenceList];
      let index = copy.indexOf(competenceId);
      copy.splice(index, 1);
      this.setState({ competenceList: copy });
    }

    let copy = [...this.state.criteriaList];
    let index = copy.indexOf(criteriaId);
    copy.splice(index, 1);
    this.setState({ criteriaList: copy });
  };

  submit = () => {
    //copy object without reference(dirty way). We can use loadash.
    let copy = JSON.parse(JSON.stringify(this.state.profiles));
    //to remove 0 which we assign below
    Array.prototype.remove = function() {
      var what,
        a = arguments,
        L = a.length,
        ax;
      while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
          this.splice(ax, 1);
        }
      }
      return this;
    };
    //if competence isn't in list it's set to 0
    copy.forEach((element, i) =>
      this.state.competenceList.includes(element.id) ? null : (copy[i] = 0)
    );

    copy.remove(0);
    //same steps but with criteria
    copy.map((data, index) =>
      data.criteriaList.map((criteria, i) => {
        this.state.criteriaList.includes(criteria.id)
          ? null
          : (copy[index].criteriaList[i] = 0);
      })
    );

    copy.map((data, index) => copy[index].criteriaList.remove(0));

    let obj = {
      position: this.state.position,
      competences: copy
    };

    if (this.state.position === null || copy.length === 0) {
      alert("Select position or criterias");
    } else {
      this.sendData(obj);
    }
  };

  sendData = obj => {
    console.log(obj);

    Axios.post("/api/profiles", {
      data: obj
    })
      .then(function(response) {
        alert("Created successfully");
      })
      .catch(function(error) {
        console.log(error);
        alert("Something went wrong... Try again later");
      });
  };

  positonInput = e => {
    this.setState({ position: e.target.value });
  };

  toogle = i => {
    if (this.state.show.includes(i)) {
      const array = [...this.state.show];
      const index = array.indexOf(i);
      array.splice(index, 1);
      this.setState({ show: array });
    } else {
      this.setState({ show: this.state.show.concat(i) });
    }
  };

  render() {
    return (
      <div className="hrPage">
        <label>Choose position: </label>
        <select onChange={e => this.positonInput(e)}>
          <option id={null} value={null}>
            --Select--
          </option>
          {this.state.positions.map(positions => (
            <option key={positions.id} value={positions.id}>
              {positions.title}
            </option>
          ))}
        </select>

        {this.state.profiles.map((competences, i) => {
          return (
            <React.Fragment key={competences.id}>
              <div className="competence">
                <h4
                  style={
                    this.state.show.includes(i)
                      ? {
                          borderBottom: "none",
                          borderRadius: "30px 30px 0px 0px"
                        }
                      : { borderRadius: "30px 30px 30px 30px" }
                  }
                  onClick={() => this.toogle(i)}
                >
                  {competences.title}
                </h4>
                {this.state.show.includes(i) ? (
                  <table>
                    <thead>
                      <tr>
                        <th>Criteria</th>
                        <th>Check to include</th>
                      </tr>
                    </thead>
                    <tbody>
                      {competences.criteriaList.map(criterias => (
                        <tr key={criterias.id}>
                          <td data-label="Criteria">{criterias.title}</td>
                          <td data-label="Check to include">
                            <CheckBox
                              add={this.add}
                              remove={this.remove}
                              competenceId={competences.id}
                              criteriaId={criterias.id}
                              criteriaList={competences.criteriaList}
                            />
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                ) : null}
              </div>
            </React.Fragment>
          );
        })}
        <button onClick={this.submit}>Save</button>
      </div>
    );
  }
}

export default HrPage;
