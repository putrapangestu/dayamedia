<style>
    .timeline-horizontal {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  position: relative;
  padding: 20px 0;
}

/* garis */
.timeline-horizontal::before {
  content: "";
  position: absolute;
  top: 4rem;
  left: 5%;
  right: 5%;
  height: 2px;
  background: #e5e7eb;
}

.timeline-item {
  flex: 1;
  text-align: center;
  position: relative;
}

.timeline-circle {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: #e11d8d; /* primary */
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  margin: 0 auto 12px;
  position: relative;
  z-index: 1;
}

.timeline-text strong {
  display: block;
  font-size: 15px;
  font-weight: 600;
}

.timeline-text span {
  display: block;
  font-size: 14px;
  color: #6b7280;
}

/* ===== STATUS ===== */

/* DONE */
.timeline-item.done .timeline-circle {
  background: #16a34a;
}

/* ACTIVE */
.timeline-item.active .timeline-circle {
  background: #e11d8d;
  box-shadow: 0 0 0 6px rgba(225, 29, 141, 0.2);
}

/* DISABLED / BELUM */
.timeline-item:not(.active):not(.done) .timeline-circle {
  background: #e5e7eb;
  color: #9ca3af;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .timeline-horizontal {
    flex-direction: column;
    gap: 24px;
    padding: 20px 10px;
  }

  .timeline-horizontal::before {
    left: 36px;
    right: auto;
    top: 0;
    bottom: 0;
    height: auto;
    width: 2px;
  }

  .timeline-item {
    display: flex;
    align-items: center;
    text-align: left;
    gap: 16px;
  }

  .timeline-circle {
    width: 56px;
    height: 56px;
    font-size: 24px;
    margin: 0;
    flex-shrink: 0;
  }

  .timeline-text {
    flex: 1;
  }

  .timeline-text strong {
    font-size: 14px;
  }

  .timeline-text span {
    font-size: 13px;
  }
}

@media (max-width: 576px) {
  .card-body.p-4 {
    padding: 1rem !important;
  }

  .timeline-circle {
    width: 48px;
    height: 48px;
    font-size: 20px;
  }

  .timeline-horizontal::before {
    left: 24px;
  }

  .timeline-text strong {
    font-size: 13px;
  }
}

</style>