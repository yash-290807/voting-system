async function loadCandidates() {

    const res = await fetch("../backend/candidates/get_candidates.php")

    const data = await res.json()

    const container = document.getElementById("candidates")

    container.innerHTML = ""

    data.forEach(c => {

        container.innerHTML += `

<div class="card">

<h3>${c.name}</h3>

<p>Party: ${c.party}</p>

<button onclick="vote(${c.id})">Vote</button>

</div>

`

    })

}

async function vote(candidateId) {

    const userId = localStorage.getItem("user_id")

    const electionId = 1

    const res = await fetch("../backend/voting/vote.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            user_id: userId,
            candidate_id: candidateId,
            election_id: electionId
        })

    })

    const data = await res.json()

    alert(data.message)

}

function logout() {

    localStorage.clear()

    window.location = "login.html"

}

loadCandidates()